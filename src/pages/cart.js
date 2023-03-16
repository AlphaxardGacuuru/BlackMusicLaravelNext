import { useState, Suspense } from 'react'
import axios from '@/lib/axios'

import VideoMedia from '@/components/Video/VideoMedia'
import AudioMedia from '@/components/Audio/AudioMedia'
import Btn from '@/components/core/Btn'

const Cart = (props) => {

	const [bottomMenu, setBottomMenu] = useState("")
	const [receipt, setReceipt] = useState()
	const [receiptVideos, setReceiptVideos] = useState([])
	const [receiptAudios, setReceiptAudios] = useState([])

	// Calculate totals
	const videoTotal = props.cartVideos.length
	const videoTotalCash = props.cartVideos.length * 20
	const audioTotal = props.cartAudios.length
	const audioTotalCash = props.cartAudios.length * 10
	const total = videoTotalCash + audioTotalCash

	// Send STKPush
	const STKPush = (amount) => {
		axios.post(`/api/stk-push/`, {amount: amount})
			.then((res) => props.setMessages([res.data]))
			.catch((err) => props.getErrors(err, true))
	}

	// Function for buying videos
	const onPay = () => {
		// Check payment after every 2s
		var intervalId = window.setInterval(() => {
			// Try and buy videos
			axios.post(`/api/bought-videos`)
				.then((res) => {
					// If videos are bought stop checking
					if (res.data.length > 0) {
						setReceiptVideos(res.data)
						setBottomMenu()
						setReceipt("menu-open")
						clearInterval(intervalId)
						// Show message
						var message
						// Proper grammar for message
						if (res.data.length > 1) {
							message = res.data.length + " Videos bought"
						} else {
							message = res.data.length + " Video bought"
						}
						props.setMessages([message])
						// Update states
						props.get("bought-videos", props.setBoughtVideos, "boughtVideos")
						props.get("videos", props.setVideos, "videos")
						props.get("cart-videos", props.setCartVideos, "cartVideos")
						props.get("videos-albums", props.setVideoAlbums, "videoAlbums")
					}
					// Stop loop after 30s
					setTimeout(() => {
						clearInterval(intervalId)
						setBottomMenu()
					}, 30000)

				}).catch((err) => props.getErrors(err))

			// Try and buy audios
			axios.post(`audio/api/bought-audios`)
				.then((res) => {
					// If videos are bought stop checking
					if (res.data.length > 0) {
						setReceiptAudios(res.data)
						setBottomMenu()
						setReceipt("menu-open")
						clearInterval(intervalId)
						// Show message after 10 seconds
						setTimeout(() => {
							var message
							// Proper grammar for message
							if (res.data.length > 1) {
								message = res.data.length + " Audios bought"
							} else {
								message = res.data.length + " Audio bought"
							}
							props.setMessages([message])
						}, 10000)
						// Update states
						props.get("bought-audios", props.setBoughtAudios, "boughtAudios")
						props.get("audios", props.setAudios, "audios")
						props.get("cart-audios", props.setCartAudios, "cartAudios")
						props.get("audios-albums", props.setAudioAlbums, "audioAlbums")
					}
					// Stop loop after 30s
					setTimeout(() => {
						clearInterval(intervalId)
						setBottomMenu()
					}, 30000)
				}).catch((err) => props.getErrors(err))
		}, 2000);
	}

	return (
		<div>
			<div className="row">
				<div className="col-sm-12">
					<center><h1>Cart</h1></center>
				</div>
			</div>
			<div className="row">
				<div className="col-sm-1"></div>
				<div className="col-sm-3">
					<div className="mb-4">
						{/* Cart Videos */}
						{props.cartVideos.length > 0 &&
							<>
								<center><h3 className="pt-4 pb-2 border-bottom border-dark">Videos</h3></center>
								<hr />
							</>}
						{props.cartVideos.map((cartVideo, key) => (
							<VideoMedia
								{...props}
								key={key}
								video={cartVideo} />
						))}
						{props.cartVideos.length > 0 &&
							<div className="d-flex justify-content-between border-top border-dark">
								<div className="p-2">
									<h4 className="text-success">Sub Total</h4>
								</div>
								<div className="p-2">
									<h4 className="text-success">{videoTotalCash}</h4>
								</div>
							</div>}
						{/* Cart Videos End */}
					</div>
				</div>
				<div className="col-sm-4">
					<div className="mb-4">
						{/* Cart Audios */}
						{props.cartAudios.length > 0 &&
							<>
								<center><h3 className="pt-4 pb-2 border-bottom border-dark">Audios</h3></center>
								<hr />
							</>}
						{props.cartAudios
							.map((cartAudio, key) => (
								<AudioMedia
									{...props}
									key={key}
									audio={cartAudio} />
							))}
						{props.cartAudios.length > 0 &&
							<div className="d-flex justify-content-between border-top border-dark">
								<div className="p-2">
									<h4 className="text-success">Sub Total</h4>
								</div>
								<div className="p-2">
									<h4 className="text-success">{audioTotalCash}</h4>
								</div>
							</div>}
						{/* Cart Audios End */}
					</div>
				</div>
				<div className="col-sm-3">
					<div className="mb-4">
						<center>
							<h3 className="pt-4 pb-2 border-bottom border-dark">Total</h3>
							<hr />
							<h3 className="text-success"> KES {total}</h3>
							<h5 className="text-success">Your account balance: KES {props.auth.balance}</h5>
							<br />

							{/* {{-- Collapse --}} */}
							{(videoTotal + audioTotal) > 0 &&
								<>
									<button
										className="mysonar-btn white-btn"
										style={{ width: "80%" }}
										type="button"
										data-bs-toggle="collapse"
										data-bs-target="#collapseExample"
										aria-expanded="false"
										aria-controls="collapseExample">
										next
									</button>
									<div className="collapse" id="collapseExample">
										<div className="">
											<br />
											<h5>Once you click the button below a pop up will appear on your phone asking you to pay</h5>
											<h4 className="text-success">KES {total}</h4>
											<h5>to</h5>
											<h4 style={{ color: "dodgerblue" }}>Kopokopo</h4>
											<br />

											{/* Checkout button */}
											<Btn
												btnClass="mysonar-btn green-btn btn-2 mb-4"
												btnText="pay with mpesa"
												btnStyle={{ width: "80%" }}
												onClick={(e) => {
													e.preventDefault()
													setBottomMenu("menu-open")
													onPay()
													// STKPush(total)
												}} />
										</div>
									</div>
								</>}
							{/* {{-- Collapse End --}} */}
							<br />
							<br />

							{/* Receipt button */}
							{(receiptVideos.length + receiptAudios.length) > 0 &&
								<Btn btnClass="mysonar-btn mb-4"
									btnText="receipt"
									btnStyle={{ width: "80%" }}
									onClick={(e) => {
										e.preventDefault()
										setReceipt("menu-open")
									}} />}
						</center>
					</div>
				</div>
				<div className="col-sm-1"></div>
			</div>

			{/* Sliding Bottom Nav */}
			<div className={bottomMenu}>
				<div className="bottomMenu">
					<div className="d-flex align-items-center justify-content-between mb-3">
						{/* <!-- Logo Area --> */}
						<div className="logo-area p-2">
							<a href="#">Payment</a>
						</div>

						{/* <!-- Close Icon --> */}
						<div
							className="closeIcon p-2 float-right"
							onClick={() => {
								setBottomMenu("")
							}}>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="40"
								height="40"
								fill="currentColor"
								className="bi bi-x"
								viewBox="0 0 16 16">
								<path
									d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
							</svg>
						</div>
					</div>

					<center>
						<h5>Request was sent to <span style={{ color: "dodgerblue" }}>{props.auth.phone}</span></h5>
						<br />

						<h6>Checking payment</h6>
						<div id="sonar-load" className="mt-4 mb-4"></div>
					</center>

					{/* {videoTotal > 0 && <h5 className="">Videos {videoTotal}</h5>}
					{audioTotal > 0 && <h5 className="mb-2">Audios {audioTotal}</h5>}

					<h4 className="text-success mb-2">Total KES {total}</h4>
					<h5 className="text-success">Mpesa (STK Push) <span>{props.auth.phone}</span></h5>
					<br />

					<Button
						btnClass="mysonar-btn green-btn"
						btnText="pay"
						btnStyle={{ width: "80%" }}
						onClick={onPay} /> */}

					<br />
					<br />
				</div>
			</div>
			{/* Sliding Bottom Nav  end */}

			{/* Sliding Receipt Bottom Nav */}
			<div className={receipt}>
				<div className="bottomMenu" style={{ height: "50%" }}>
					<div className="d-flex align-items-center justify-content-between mb-3">
						{/* <!-- Logo Area --> */}
						<div className="logo-area p-2">
							<a href="#">Receipt</a>
						</div>

						{/* <!-- Close Icon --> */}
						<div className="closeIcon p-2 float-right" onClick={() => setReceipt("")}>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="40"
								height="40"
								fill="currentColor"
								className="bi bi-x"
								viewBox="0 0 16 16">
								<path
									d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
							</svg>
						</div>
					</div>

					<div
						className="px-2 pb-4"
						style={{
							height: "100%",
							overflowY: "scroll",
							textAlign: "left"
						}}>
						<center>
							<h4 className="text-success">Congratulations</h4>
							<h5 className="text-success">Purchase successful!</h5>
						</center>
						{/* Cart Videos */}
						{receiptVideos.length > 0 && <center><h4>Videos</h4></center>}
						{receiptVideos
							.map((receiptVideo, key) => (
								<VideoMedia
									{...props}
									key={key}
									video={receiptVideo} />
							))}
						{/* Cart Videos End */}

						{/* Cart Audios */}
						{receiptAudios.length > 0 && <center><h4 className="mt-4">Audios</h4></center>}
						{receiptAudios
							.map((receiptAudio, key) => (
								<AudioMedia
									{...props}
									key={key}
									audio={receiptAudio} />
							))}
						<br />
						<br />
					</div>
				</div>
			</div>
			{/* Sliding Receipt Bottom Nav end */}
		</div>
	)
}

export default Cart