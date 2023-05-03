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
			<Img
				src={props.story.media}
				width="360em"
				height="640em"
				className="mt-3"
			/>

			{/* Floating Video Info Top */}
			<div style={{ position: "absolute", top: 20 }}>
				<div className="d-flex">
					{/* Close Icon */}
					<div className="">
						<Link href="/">
							<a style={{ fontSize: "1.5em" }}>
								<CloseSVG />
							</a>
						</Link>
					</div>
				</div>
			</div>
			{/* Floating Video Info Top End */}
		</span>
	)
}

export default Story
