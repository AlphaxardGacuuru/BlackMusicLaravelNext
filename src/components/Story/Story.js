import { useEffect, useRef, useState } from "react"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "next/image"

import CloseSVG from "@/svgs/CloseSVG"

const Story = (props) => {
	const [timer, setTimer] = useState()
	const [percent, setPercent] = useState("0%")
	const [sendSeenAt, setSendSeenAt] = useState()
	const [hasMuted, setHasMuted] = useState(props.story.hasMuted)
	const [segment, setSegment] = useState(0)
	const [freeze, setFreeze] = useState(true)

	/*
	 * Intersection Observer API
	 */

	var t
	var time = 0
	var index = 0

	// Set options
	let options = {
		root: null,
		rootMargin: "0px",
		threshold: 0.9,
	}

	useEffect(() => {
		setTimeout(() => {
			let observer = new IntersectionObserver(callback, options)

			const storyEl = document.getElementById(props.story.id)

			observer.observe(storyEl)
		}, 500)

		return () => clearInterval(t)
	}, [])

	/*
	 * Intersection Observer API Callback function */
	let callback = (entries, observer) => {
		if (entries != "undefined") {
			entries.forEach((entry) => {
				// Start or Clear progress bar
				if (entry.isIntersecting) {
					time = 0
					setSegment(0)
					handleTimer()
				} else {
					// Use t instead of timer to prevent rerendering
					clearInterval(t)
					setPercent("0%")
				}
			})
		}
	}

	/*
	 * Handle Timer */
	const handleTimer = () => {
		t = setInterval(() => {
			// Stop incrementing after 5s (50 because its deciseconds)
			if (time < 55) {
				handleProgressBar()
			} else {
				// Go to next story segment
				const length = props.story.media.length
				const length2 = length - 1

				if (segment < length2 && length > 1) {
					setSegment(segment + 1)
					time = 0
				} else {
					scrollToNextStory()
				}
			}
		}, 100)

		setTimer(t)
	}

	/*
	 * Function for incrementing progress bar */
	const handleProgressBar = () => {
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
	}

	/*
	 * Function for scrolling to next story */
	const scrollToNextStory = () => {
		clearInterval(t)

		// Get index of current story in array
		index = props.stories.indexOf(props.story)
		// Increment to get the next story if there are still some
		if (index < props.stories.length - 1) {
			index++
		}
		// Get ID of the story
		var nextIndex = props.stories[index].id
		// Get the Element of the story
		var storyEl = document.getElementById(nextIndex)
		// Get left offset of the element inorder to know how far to scroll
		var left = storyEl.offsetLeft
		// Scroll to next story element
		props.storyScroller.current.scrollTo({
			top: 0,
			left: left,
			behavior: "smooth",
		})
	}

	/*
	 * Mark story as seen */
	useEffect(() => {
		if (sendSeenAt) {
			axios.post(`/api/stories/seen/${props.story.id}`)
		}
	}, [sendSeenAt])

	/*
	 * Mute stories from user */
	const onMute = () => {
		// Change state
		setHasMuted(!hasMuted)

		axios
			.post(`/api/stories/mute/${props.story.username}`, { _method: "PUT" })
			.then((res) => props.setMessages([res.data.message]))
			.catch((err) => props.getErrors(err, true))
	}

	/*
	 * Freeze and Unfreeze story */
	const onFreeze = () => {
		setFreeze(!freeze)

		if (freeze) {
			setTimer(timer)
			clearInterval(timer)
		} else {
			handleTimer()
		}
	}

	return (
		<span id={props.story.id} className="single-story">
			<div style={{ height: "100vh", width: "auto" }} onClick={onFreeze}>
				{Object.keys(props.story.media[segment]) == "image" ? (
					<Img
						src={`/storage/${props.story.media[segment]["image"]}`}
						layout="fill"
					/>
				) : (
					<video
						width="495px"
						height="880px"
						controls={false}
						controlsList="nodownload"
						autoPlay>
						<source
							src={`/storage/${props.story.media[segment]["video"]}`}
							type="video/mp4"
						/>
					</video>
				)}
			</div>

			{/* Floating Video Info Top */}
			<div style={{ position: "absolute", top: 0, left: 0, width: "100%" }}>
				<div className="d-flex">
					{/* Track */}
					{props.story.media.map((story, key) => (
						<div key={key} className="w-100 pt-2 mx-2">
							<div className="progress rounded-0" style={{ height: "2px" }}>
								<div
									className="progress-bar bg-warning"
									style={{ width: segment == key ? percent : 0 }}></div>
							</div>
						</div>
					))}
					{/* Track End */}
				</div>
				<div className="d-flex justify-content-between">
					{/* Close Icon */}
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
									onFreeze()
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
									href="#"
									className="dropdown-item border-bottom border-dark"
									onClick={onMute}>
									<h6>{hasMuted ? "Unmute" : "Mute"}</h6>
								</a>
							</div>
						</div>
					</div>
					{/* Avatar End */}
				</div>
				{/* Click fields */}
				<div className="d-flex justify-content-between">
					<div
						className="p-3"
						style={{ minHeight: "90vh" }}
						onClick={() => {
							// setSegment(segment - 1)
							console.log("2 segment is " + segment)
						}}>
						<span className="invisible">left</span>
					</div>
					<div
						className="p-3"
						style={{ minHeight: "90vh" }}
						onClick={() => {
							// setSegment(segment + 1)
							console.log("3 segment is " + segment)
						}}>
						<span className="invisible">right</span>
					</div>
				</div>
				{/* Click fields End */}
			</div>
			{/* Floating Video Info Top End */}
		</span>
	)
}

export default Story
