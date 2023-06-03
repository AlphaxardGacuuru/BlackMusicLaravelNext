import { useEffect } from "react"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "next/image"

import CloseSVG from "@/svgs/CloseSVG"

const Story = (props) => {
	useEffect(() => {
		// setTimeout(() => {
		// axios.post(`/api/stories/${props.story.id}`, {
		// _method: "PUT",
		// seen_at: new Date,
		// })
		// }, 2000)

		return () => {}
	}, [])

	return (
		<span id={props.story.id} className="single-story">
			<div style={{ height: "100vh", width: "auto" }}>
				<Img src={props.story.media} layout="fill" />
			</div>

			{/* Floating Video Info Top */}
			<div style={{ position: "absolute", top: 0, left: 0, width: "100%" }}>
				<div className="d-flex">
					<div className="w-100 pt-2 mx-2">
						{/* Track */}
						<div className="progress rounded-0" style={{ height: "2px" }}>
							<div className="progress-bar bg-warning w-50"></div>
						</div>
						{/* Track End */}
					</div>
				</div>
				<div className="d-flex justify-content-between">
					<div className="">
						<Link href="/">
							<a style={{ fontSize: "1.5em" }}>
								<CloseSVG />
							</a>
						</Link>
					</div>
					{/* Close Icon End */}
					{/* Name */}
					<div className="px-2">
						<h6
							className="m-0 pt-2 px-1"
							style={{
								width: "15em",
								whiteSpace: "nowrap",
								overflow: "hidden",
								textOverflow: "clip"
							}}>
							{props.story.name}
						</h6>
						<h6>
							<small>{props.story.username}</small>
						</h6>
					</div>
					{/* Name End */}
					{/* Avatar */}
					<div className="py-2 me-3" style={{ minWidth: "40px" }}>
						<Link href={`/profile/${props.story.username}`}>
							<a>
								<Img
									src={props.story.avatar}
									className="rounded-circle"
									width="40px"
									height="40px"
									alt="user"
									loading="lazy"
								/>
							</a>
						</Link>
					</div>
					{/* Avatar End */}
				</div>
			</div>
			{/* Floating Video Info Top End */}
		</span>
	)
}

export default Story
