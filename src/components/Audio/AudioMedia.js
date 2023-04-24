import Link from "next/link"
import { useRouter } from "next/router"
import axios from "@/lib/axios"

import Img from "next/image"
import Btn from "../Core/Btn"
import CartSVG from "../../svgs/CartSVG"
import { useState } from "react"

const AudioMedia = (props) => {
	const router = useRouter()

	const [inCart, setInCart] = useState(props.audio.inCart)

	// Buy function
	const onBuyAudios = () => {
		onCartAudios()
		setTimeout(() => router.push("/cart"), 500)
	}

	// Function for adding audio to cart
	const onCartAudios = () => {
		// Add Audio to Cart
		axios
			.post(`/api/cart-audios`, {
				audio: props.audio.id,
			})
			.then((res) => {
				props.setMessages([res.data])
				// Check if Cart Videos should be fetched
				props.get("cart-audios", props.setCartAudios)
			})
			.catch((err) => props.getErrors(err, true))
	}

	return (
		<div className="d-flex p-2">
			<div className="audio-thumbnail">
				<Link href={`/audio/${props.audio.id}`}>
					<a
						onClick={() => {
							props.audioStates.setShow({ id: props.audio.id, time: 0 })
							props.setLocalStorage("show", {
								id: props.audio.id,
								time: 0,
							})
						}}>
						<Img src={props.audio.thumbnail} width="50px" height="50px" />
					</a>
				</Link>
			</div>
			<div className="p-2 me-auto">
				<span
					onClick={() => {
						props.audioStates.setShow({ id: props.audio.id, time: 0 })
						props.setLocalStorage("show", {
							id: props.audio.id,
							time: 0,
						})
					}}>
					<h6 className="mb-0 pb-0 audio-text">{props.audio.name}</h6>
					<h6 className="mt-0 pt-0 audio-text">
						<small>{props.audio.username}</small>
						<small className="ms-1">{props.audio.ft}</small>
					</h6>
				</span>
			</div>
			{props.audio.hasBoughtAudio || props.hasBoughtAudio ? (
				""
			) : inCart ? (
				<div>
					<button
						className="btn text-light rounded-0 pt-1"
						style={{
							minWidth: "40px",
							height: "33px",
							backgroundColor: "#232323",
						}}
						onClick={() => {
							setInCart(!inCart)
							onCartAudios()
						}}>
						<CartSVG />
					</button>
				</div>
			) : (
				<>
					<div>
						<button
							className="mysonar-btn white-btn"
							style={{ minWidth: "40px", height: "33px" }}
							onClick={() => {
								setInCart(!inCart)
								onCartAudios()
							}}>
							<CartSVG />
						</button>
					</div>
					<div className="ms-2">
						<Btn
							btnClass="mysonar-btn green-btn btn-2 float-right"
							btnText="KES 10"
							onClick={() => onBuyAudios()}
						/>
					</div>
				</>
			)}
		</div>
	)
}

AudioMedia.defaultProps = {
	hasBoughtAudio: false,
}

export default AudioMedia
