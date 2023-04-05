import Link from "next/link"
import { useRouter } from "next/router"
import onCartVideos from "@/functions/onCartVideos"

import Img from "next/image"
import Btn from "../Core/Btn"

import CartSVG from "@/svgs/CartSVG"

const VideoMedia = (props) => {
	const router = useRouter()

	// Buy function
	const onBuyVideos = (video) => {
		onCartVideos(props, video)
		setTimeout(() => router.push("/cart"), 500)
	}

	return (
		<span
			className="mx-2 pt-0 px-0 pb-2 my-card"
			style={{ display: "inline-block" }}
			onClick={() => {
				props.audioStates.pauseSong()
				props.audioStates.setShow({ id: 0, time: 0 })
			}}>
			<div className="video-media">
				<div className="video-thumbnail">
					<Link href={`/video/${props.video.id}`} passHref>
						<a>
							<Img src={props.video.thumbnail} width="320em" height="180em" />
						</a>
					</Link>
				</div>
				{props.video.hasBoughtVideo || props.hasBoughtVideo ? (
					""
				) : (
					<div className="d-flex justify-content-around video-media-overlay">
						{props.video.inCart ? (
							<div>
								<button
									className="btn text-light mb-1 rounded-0 pt-1"
									style={{
										minWidth: "90px",
										height: "33px",
										backgroundColor: "#232323",
									}}
									onClick={() => onCartVideos(props, props.video.id)}>
									<CartSVG />
								</button>
							</div>
						) : (
							<>
								<div>
									<button
										className="mysonar-btn white-btn mb-1 fs-6"
										style={{
											minWidth: "90px",
											height: "33px",
										}}
										onClick={() => onCartVideos(props, props.video.id)}>
										<CartSVG />
									</button>
								</div>
								<div>
									<Btn
										btnClass="mysonar-btn green-btn btn-2"
										btnText="KES 20"
										onClick={() => onBuyVideos(props.video.id)}
									/>
								</div>
							</>
						)}
					</div>
				)}
			</div>
			<div className="d-flex" style={{ maxWidth: "220em" }}>
				<div className="py-2" style={{ minWidth: "40px" }}>
					<Link href={`/profile/${props.video.username}`}>
						<a>
							<Img
								src={props.video.avatar}
								className="rounded-circle"
								width="40px"
								height="40px"
								alt="user"
								loading="lazy"
							/>
						</a>
					</Link>
				</div>
				<div className="px-2">
					<h6
						className="m-0 pt-2 px-1"
						style={{
							width: "15em",
							whiteSpace: "nowrap",
							overflow: "hidden",
							textOverflow: "clip",
							textAlign: "left",
						}}>
						{props.video.name}
					</h6>
					<h6 className="float-start">
						<small>
							{props.video.username} {props.video.ft}
						</small>
					</h6>
				</div>
			</div>
		</span>
	)
}

VideoMedia.defaultProps = {
	hasBoughtVideo: false,
}

export default VideoMedia
