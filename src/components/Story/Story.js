import { useEffect, useRef, useState } from "react"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "next/image"

import CloseSVG from "@/svgs/CloseSVG"

const Story = (props) => {
	const [percent, setPercent] = useState("0%")
	const [sendSeenAt, setSendSeenAt] = useState()

	var timer

	/*
	 * Handle Timer */
	const handleTimer = () => {
		var time = 0

		/*
		 * Show timer */
		timer = setInterval(() => {
			// Stop incrementing after 5s (50 because its deciseconds)
			if (time < 50) {
				// Increment time by 1
				time++
				// Get percentage
				var per = (time * 100) / 50
				// Format percentage for style
				per = per + "%"
				// Set percent for showing on bar
				setPercent(per)

				if (time > 30) {
					setSendSeenAt(true)
				}
			} else {
				// Get index of current story in array
				var index = props.stories.indexOf(props.story)

				index++

				var nextIndex = props.stories[index].id

				props.setIndex(nextIndex)

				clearTimeout(timer)
			}
		}, 100)
	}

	/*
	 * Intersection Observer API
	 */

	// Set options
	let options = {
		root: null,
		rootMargin: "0px",
		threshold: 0.9,
	}

	/*
	 * Intersection Observer API Callback function */
	let callback = (entries, observer) => {
		entries.forEach((entry) => {
			// Start or Clear progress bar
			if (entry.isIntersecting) {
				handleTimer()
			} else {
				clearTimeout(timer)
				setPercent("0%")
			}
		})
	}

	useEffect(() => {
		let observer = new IntersectionObserver(callback, options)

		const storyEl = document.getElementById(props.story.id)

		observer.observe(storyEl)

		return () => clearTimeout(timer)
	}, [])

	/*
	 * Set Seen At */
	useEffect(() => {
		if (sendSeenAt) {
			onSeen()
		}
	}, [sendSeenAt])

	/*
	 * Mark story as seen */
	const onSeen = () => {
		axios.post(`/api/stories/seen/${props.story.id}`)
	}

	/*
	 * Mute stories from user */
	const onMute = () => {
		axios
			.post(`/api/stories/mute/${props.story.username}`, { _method: "PUT" })
			.then((res) => props.setMessages([res.data]))
			.catch((err) => props.getErrors(err, true))
	}

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
							<div
								className="progress-bar bg-warning"
								style={{ width: percent }}></div>
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
								textOverflow: "clip",
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
						<div className="dropdown-center">
							<a
								href="#"
								role="button"
								data-bs-toggle="dropdown"
								aria-expanded="false"
								onClick={(e) => {
									e.preventDefault()
									console.log("cleared")
									clearTimeout(timer)
								}}>
								<Img
									src={props.story.avatar}
									className="rounded-circle"
									width="40px"
									height="40px"
									alt="user"
									loading="lazy"
								/>
							</a>
							<div
								style={{ backgroundColor: "#232323" }}
								className="dropdown-menu rounded-0 m-0 p-0">
								<Link href={`/profile/${props.story.username}`}>
									<a className="pt-2 dropdown-item border-bottom border-dark">
										<h6>View profile</h6>
									</a>
								</Link>
								<Link href={`/chat/${props.story.username}`}>
									<a className="dropdown-item border-bottom border-dark">
										<h6>Message</h6>
									</a>
								</Link>
								<a
									className="dropdown-item border-bottom border-dark"
									onClick={onMute}>
									<h6>Mute</h6>
								</a>
							</div>
						</div>
					</div>
					{/* Avatar End */}
				</div>
			</div>
			{/* Floating Video Info Top End */}
		</span>
	)
}

export default Story
