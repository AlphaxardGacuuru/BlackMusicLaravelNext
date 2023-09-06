import React, { useState, Suspense, useEffect } from "react"
// import Axios from "axios"
// import Echo from "Echo"

import VideoMedia from "@/components/Video/VideoMedia"
import AudioMedia from "@/components/Audio/AudioMedia"
import Btn from "@/components/Core/Btn"

import CloseSVG from "@/svgs/CloseSVG"

const Cart = (props) => {
	const [messages, setMessages] = useState([])
	const [bottomMenu, setBottomMenu] = useState("")
	const [receipt, setReceipt] = useState("")
	const [receiptVideos, setReceiptVideos] = useState([])
	const [receiptAudios, setReceiptAudios] = useState([])

	// Calculate totals
	const videoTotal = props.cartVideos.length
	const videoTotalCash = props.cartVideos.length * 20
	const audioTotal = props.cartAudios.length
	const audioTotalCash = props.cartAudios.length * 10
	const total = videoTotalCash + audioTotalCash

	useEffect(() => {
		/*
		 * Listen to Kopokopo Payments
		 */
		Echo.private(`kopokopo-created`).listen("KopokopoCreatedEvent", (e) => {
			setMessages([`Payment of KES ${e.kopokopo.amount} received`])
			setBottomMenu("")
		})

		/*
		 * Listen to Bought Videos
		 */
		Echo.private(`video-bought`).listen("VideoBoughtEvent", (e) => {
			setReceiptVideos(e.structuredVideos)
			setBottomMenu()
			setReceipt("menu-open-comment")
			// Show message
			var message = `${e.structuredVideos.length} Video${
				e.structuredVideos.length > 1 ? "s" : ""
			} bought`
			setMessages([...messages, message])
			// Update state
			props.get("cart-videos", props.setCartVideos)
		})

		/*
		 * Listen to Bought Audios
		 */
		Echo.private(`audio-bought`).listen("AudioBoughtEvent", (e) => {
			setReceiptAudios(e.structuredAudios)
			setBottomMenu()
			setReceipt("menu-open-comment")
			var message = `${e.structuredAudios.length} Audio${
				e.structuredAudios.length > 1 ? "s" : ""
			} bought`
			setMessages([...messages, message])
			// Update states
			props.get("cart-audios", props.setCartAudios, "cartAudios")
		})

		props.get("cart-videos", props.setCartVideos)
		props.get("cart-audios", props.setCartAudios)

		return () => {
			Echo.leave("kopokopo-created")
			Echo.leave("video-bought")
			Echo.leave("audio-bought")
		}
	}, [])

	// Reset Messages to null after 5 seconds
	if (messages.length > 0) {
		setTimeout(() => setMessages([]), 5000)
	}

	// Send STKPush
	const STKPush = (amount) => {
		Axios.post(`/api/stk-push`, { amount: amount })
			.then((res) => props.setMessages([res.data.message]))
			.catch((err) => props.getErrors(err, true))
	}

	return (
		<div>
			<div className="row">
				{messages.map((message, key) => (
					<center key={key}>
						<h6
							id="snackbar-up"
							style={{ cursor: "pointer" }}
							className="show bg-success"
							onClick={() => setMessages([])}>
							<div>{message}</div>
						</h6>
					</center>
				))}
				<div className="col-sm-12">
					<center>
						<h1>Cart</h1>
					</center>
				</div>
			</div>
			<div className="row">
				<div className="col-sm-1"></div>
				<div className="col-sm-3">
					<div className="mb-4">
						<center>
							{/* Cart Videos */}
							{props.cartVideos.length > 0 && (
								<>
									<h3 className="pt-4 pb-2 border-bottom border-dark">
										Videos
									</h3>
									<hr />
								</>
							)}
							{props.cartVideos.map((cartVideo, key) => (
								<VideoMedia
									{...props}
									key={key}
									video={cartVideo}
								/>
							))}
							{props.cartVideos.length > 0 && (
								<div className="d-flex justify-content-between border-top border-dark">
									<div className="p-2">
										<h4 className="text-success">Sub Total</h4>
									</div>
									<div className="p-2">
										<h4 className="text-success">{videoTotalCash}</h4>
									</div>
								</div>
							)}
							{/* Cart Videos End */}
						</center>
					</div>
				</div>
				<div className="col-sm-4">
					<div className="mb-4">
						{/* Cart Audios */}
						{props.cartAudios.length > 0 && (
							<>
								<center>
									<h3 className="pt-4 pb-2 border-bottom border-dark">
										Audios
									</h3>
								</center>
								<hr />
							</>
						)}
						{props.cartAudios.map((cartAudio, key) => (
							<AudioMedia
								{...props}
								key={key}
								audio={cartAudio}
								setCartAudios={props.setCartAudios}
							/>
						))}
						{props.cartAudios.length > 0 && (
							<div className="d-flex justify-content-between border-top border-dark">
								<div className="p-2">
									<h4 className="text-success">Sub Total</h4>
								</div>
								<div className="p-2">
									<h4 className="text-success">{audioTotalCash}</h4>
								</div>
							</div>
						)}
						{/* Cart Audios End */}
					</div>
				</div>
				<div className="col-sm-3">
					<div className="mb-4">
						<center>
							<h3 className="pt-4 pb-2 border-bottom border-dark">Total</h3>
							<hr />
							<h3 className="text-success"> KES {total}</h3>
							<h5 className="text-success">
								Your account balance: KES {props.auth.balance}
							</h5>
							<br />

							{/* Next Collapse End */}
							{videoTotal + audioTotal > 0 && (
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
											<h5>
												Once you click the button below a pop up will appear on
												your phone asking you to pay
											</h5>
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
													// onPay()
													STKPush(total)
												}}
											/>
										</div>
									</div>
								</>
							)}
							{/* Next Collapse End */}
							<br />
							<br />

							{/* Receipt button */}
							{receiptVideos.length + receiptAudios.length > 0 && (
								<Btn
									btnClass="mysonar-btn mb-4"
									btnText="receipt"
									btnStyle={{ width: "80%" }}
									onClick={(e) => {
										e.preventDefault()
										setReceipt("menu-open-comment")
									}}
								/>
							)}
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
							className="closeIcon p-2 float-right fs-6"
							onClick={() => setBottomMenu("")}>
							<CloseSVG />
						</div>
					</div>

					<center>
						<h5>
							Request was sent to
							<span style={{ color: "dodgerblue" }}> {props.auth.phone}</span>
						</h5>
						<br />

						<h6>Checking payment</h6>
						<div id="sonar-load" className="mt-4 mb-4"></div>
					</center>

					<br />
					<br />
				</div>
			</div>
			{/* Sliding Bottom Nav  end */}

			{/* Sliding Receipt Bottom Nav */}
			<div className={receipt}>
				<div className="commentMenu" style={{ height: "50%" }}>
					<div className="d-flex align-items-center justify-content-between mb-3">
						{/* <!-- Logo Area --> */}
						<div className="logo-area p-2">
							<a href="#">Receipt</a>
						</div>

						{/* <!-- Close Icon --> */}
						<div
							className="closeIcon p-2 float-right fs-6"
							onClick={() => setReceipt("")}>
							<CloseSVG />
						</div>
					</div>

					<div
						className="px-2 pb-4"
						style={{
							height: "100%",
							overflowY: "scroll",
							textAlign: "left",
						}}>
						<center>
							<h4 className="text-success">Congratulations</h4>
							<h5 className="text-success">Purchase successful!</h5>
						</center>
						{/* Cart Videos */}
						{receiptVideos.length > 0 && (
							<center>
								<h4>Videos</h4>
							</center>
						)}
						<center>
							{receiptVideos.map((receiptVideo, key) => (
								<VideoMedia {...props} key={key} video={receiptVideo} />
							))}
						</center>
						{/* Cart Videos End */}

						{/* Cart Audios */}
						{receiptAudios.length > 0 && (
							<center>
								<h4 className="mt-4">Audios</h4>
							</center>
						)}
						{receiptAudios.map((receiptAudio, key) => (
							<AudioMedia {...props} key={key} audio={receiptAudio} />
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
