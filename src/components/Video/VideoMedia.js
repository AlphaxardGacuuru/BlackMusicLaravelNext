import Link from 'next/link'

import Img from 'next/image'
import Button from '../Btn'

import CartSVG from '../../svgs/CartSVG'

const VideoMedia = (props) => {
	return (
		<span className="mx-2 pt-0 px-0 pb-2" style={{ display: "inline-block" }}>
			<div className="video-media">
				<div className="video-thumbnail">
					<Link href={`/video-show/${props.video.id}`} passHref>
						<a>
							<Img src={props.video.thumbnail}
								width="320em"
								height="180em" />
						</a>
					</Link>
				</div>
				<div className="d-flex justify-content-around video-media-overlay">
					{!props.video.hasBoughtVideo && !props.hasBoughtVideo ?
						props.video.inCart ?
							<div>
								<button
									className="btn text-light mb-1 rounded-0"
									style={{
										minWidth: "90px",
										height: "33px",
										backgroundColor: "#232323"
									}}
									onClick={() => props.onCartVideos(props.video.id)}>
									<CartSVG />
								</button>
							</div> :
							<>
								<div>
									<button
										className="mysonar-btn white-btn mb-1"
										style={{ minWidth: '90px', height: '33px' }}
										onClick={() => props.onCartVideos(props.video.id)}>
										<CartSVG />
									</button>
								</div>
								<div>
									<Button
										btnClass="btn mysonar-btn green-btn btn-2"
										btnText="KES 20"
										onClick={() => props.onBuyVideos(props.video.id)} />
								</div>
							</> : ""}
				</div>
			</div>
			<div className="d-flex" style={{ maxWidth: "220em" }}>
				<div className="px-1">
					<Link href={`/video-show/${props.video.id}`}>
						<a>
							<h6 className="m-0 pt-2 px-1"
								style={{
									width: "100%",
									whiteSpace: "nowrap",
									overflow: "hidden",
									textOverflow: "clip",
								}}>
								{props.video.name}
							</h6>
							<h6>
								<small>{props.video.username} {props.video.ft}</small>
							</h6>
						</a>
					</Link>
				</div>
			</div>
		</span>
	)
}

VideoMedia.defaultProps = {
	hasBoughtVideo: false
}

export default VideoMedia