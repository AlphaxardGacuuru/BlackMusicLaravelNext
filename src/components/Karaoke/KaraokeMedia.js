import Link from 'next/link'
import Img from 'next/image'

const KaraokeMedia = (props) => {
	return (
		<div
			className="m-1 karaoke-media"
			onClick={() => props.setShow(0)}>
			<div>
				<Link href={props.link}>
					<a>
						<video
							src={props.src}
							width="100%"
							preload="none"
							autoPlay
							muted
							loop
							playsInline>
						</video>
					</a>
				</Link>
			</div>
			<div className="d-flex">
				<div className="py-2 w-25">
					<Link href={`/profile/${props.username}`}>
						<a>
							<Img
								src={props.avatar}
								className="rounded-circle"
								width="40em"
								height="40em"
								alt="user"
								loading="lazy" />
						</a>
					</Link>
				</div>
				<div className="px-2">
					<h6 className="m-0 pt-2 px-1"
						style={{
							width: "150px",
							whiteSpace: "nowrap",
							overflow: "hidden",
							textOverflow: "clip",
							textAlign: "left"
						}}>
						{props.name}
					</h6>
					<h6 className="mt-0 mx-1 mb-2 px-1 py-0" style={{ textAlign: "left" }}>{props.username}</h6>
				</div>
			</div>
		</div>
	)
}

export default KaraokeMedia