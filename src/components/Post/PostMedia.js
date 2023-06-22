import { useEffect, useState } from "react"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "@/components/Core/Img"
import Poll from "./Poll"

import DecoSVG from "../../svgs/DecoSVG"
import OptionsSVG from "../../svgs/OptionsSVG"
import CommentSVG from "../../svgs/CommentSVG"
import HeartSVG from "../../svgs/HeartSVG"
import HeartFilledSVG from "../../svgs/HeartFilledSVG"
import ShareSVG from "../../svgs/ShareSVG"
import CloseSVG from "@/svgs/CloseSVG"

const PostMedia = (props) => {
	const [hasLiked, setHasLiked] = useState(props.post.hasLiked)
	const [hasMuted, setHasMuted] = useState(props.post.hasMuted)
	const [hasFollowed, setHasFollowed] = useState(props.post.hasFollowed)
	const [bottomMenu, setBottomMenu] = useState("")

	useEffect(() => {
		// Set new cart with data with auth
		setHasLiked(props.post.hasLiked)
	}, [props.post])

	// Function for voting in poll
	const onPoll = (post, parameter) => {
		axios
			.post(`/api/polls`, { post: post, parameter: parameter })
			.then((res) => props.setMessages([res.data]))
			.catch((err) => props.getErrors(err, true))
	}

	// Function for liking posts
	const onPostLike = (post) => {
		setHasLiked(!hasLiked)

		// Add like to database
		axios
			.post(`/api/post-likes`, { post: post })
			.then((res) => {
				props.setMessages([res.data])
				// Update posts
				props.setPosts && props.get("posts", props.setPosts, "posts")
			})
			.catch((err) => props.getErrors(err))
	}

	// Web Share API for share button
	// Share must be triggered by "user activation"
	const onShare = (post) => {
		// Define share data
		const shareData = {
			title: post.text,
			text: `Check out this post on Black Music\n`,
			url: `https://music.black.co.ke/#/post-show/${post.id}`,
		}
		// Check if data is shareble
		navigator.canShare(shareData) && navigator.share(shareData)
	}

	/*
	 * Function for Muting */
	const onMute = () => {
		// Change state
		setHasMuted(!hasMuted)

		axios
			.post(`/api/posts/mute/${props.post.username}`, { _method: "PUT" })
			.then((res) => {
				props.setMessages([res.data])
				// Update posts
				props.setPosts && props.get("posts", props.setPosts, "posts")
				props.setArtistPosts &&
					props.get(
						`artist/posts/${props.post.username}`,
						props.setArtistPosts
					)
			})
			.catch((err) => props.getErrors(err, true))
	}

	/*
	 * Function for Following user */
	const onFollow = () => {
		// Change state
		setHasFollowed(!hasFollowed)

		axios
			.post(`/api/follows`, { musician: props.post.username })
			.then((res) => {
				props.setMessages([res.data])
				// Update posts
				props.setPosts && props.get("posts", props.setPosts, "posts")
				// Update artist posts
				props.setArtistPosts &&
					props.get(`artist/posts/${props.post.username}`, props.setArtistPosts)
				// Update users
				props.setUsers && props.get("users", props.setUsers, "users")
			})
			.catch((err) => props.getErrors(err, true))
	}

	return (
		<div>
			<div className="d-flex">
				<div className="p-1">
					<div className="avatar-thumbnail-xs" style={{ borderRadius: "50%" }}>
						<Link href={`/profile/${props.post.username}`}>
							<a>
								<Img
									src={props.post.avatar}
									width="50px"
									height="50px"
									alt={"avatar"}
								/>
							</a>
						</Link>
					</div>
				</div>
				<div className="p-1 flex-grow-1">
					<h6 className="m-0 clip-name">
						<b>{props.post.name}</b>
						<small>{props.post.username}</small>
						<span className="ms-1" style={{ color: "gold" }}>
							<DecoSVG />
							<small
								className="ms-1 fw-lighter"
								style={{ color: "inherit" }}>
								{props.post.decos}
							</small>
						</span>
						<small>
							<b>
								<i className="float-end text-secondary me-1">
									{props.post.createdAt}
								</i>
							</b>
						</small>
					</h6>
					<Link href={"post/" + props.post.id}>
						<a>
							<p className="mb-0">{props.post.text}</p>
						</a>
					</Link>

					{/* Show media */}
					<div className="mb-1" style={{ overflow: "hidden" }}>
						{props.post.media && (
							<Img
								src={props.post.media}
								width="100%"
								height="20em"
								alt="post-media"
							/>
						)}
					</div>

					{/* Polls */}
					{/* Parameter 1 */}
					<Poll
						{...props}
						parameter={props.post.parameter_1}
						hasVoted={props.post.hasVoted1}
						width={`${props.post.percentage1}%`}
						bgColor={
							props.post.parameter_1 == props.post.winner
								? "#FFD700"
								: "#232323"
						}
						bgColor2={
							props.post.parameter_1 == props.post.winner ? "#FFD700" : "grey"
						}
						text={`${props.post.parameter_1} - ${props.post.percentage1} %`}
						onPoll={onPoll}
					/>

					{/* Parameter 2 */}
					<Poll
						{...props}
						parameter={props.post.parameter_2}
						hasVoted={props.post.hasVoted2}
						width={`${props.post.percentage2}%`}
						bgColor={
							props.post.parameter_2 == props.post.winner
								? "#FFD700"
								: "#232323"
						}
						bgColor2={
							props.post.parameter_2 == props.post.winner ? "#FFD700" : "grey"
						}
						text={`${props.post.parameter_2} - ${props.post.percentage2} %`}
						onPoll={onPoll}
					/>

					{/* Parameter 3 */}
					<Poll
						{...props}
						parameter={props.post.parameter_3}
						hasVoted={props.post.hasVoted3}
						width={`${props.post.percentage3}%`}
						bgColor={
							props.post.parameter_3 == props.post.winner
								? "#FFD700"
								: "#232323"
						}
						bgColor2={
							props.post.parameter_3 == props.post.winner ? "#FFD700" : "grey"
						}
						text={`${props.post.parameter_3} - ${props.post.percentage3} %`}
						onPoll={onPoll}
					/>

					{/* Parameter 4 */}
					<Poll
						{...props}
						parameter={props.post.parameter_4}
						hasVoted={props.post.hasVoted4}
						width={`${props.post.percentage4}%`}
						bgColor={
							props.post.parameter_4 == props.post.winner
								? "#FFD700"
								: "#232323"
						}
						bgColor2={
							props.post.parameter_4 == props.post.winner ? "#FFD700" : "grey"
						}
						text={`${props.post.parameter_4} - ${props.post.percentage4} %`}
						onPoll={onPoll}
					/>

					{/* Parameter 5 */}
					<Poll
						{...props}
						parameter={props.post.parameter_5}
						hasVoted={props.post.hasVoted5}
						width={`${props.post.percentage5}%`}
						bgColor={
							props.post.parameter_4 == props.post.winner
								? "#FFD700"
								: "#232323"
						}
						bgColor2={
							props.post.parameter_4 == props.post.winner ? "#FFD700" : "grey"
						}
						text={`${props.post.parameter_5} - ${props.post.percentage5} %`}
						onPoll={onPoll}
					/>

					{/* Total votes */}
					{props.post.parameter_1 ? (
						props.post.username == props.auth?.username ||
						!props.post.isWithin24Hrs ? (
							<small style={{ color: "grey" }}>
								<i>Total votes: {props.post.totalVotes}</i>
								<br />
							</small>
						) : (
							""
						)
					) : (
						""
					)}
					{/* Polls End */}

					{/* Post likes */}
					{hasLiked ? (
						<a
							href="#"
							style={{ color: "#fb3958" }}
							onClick={(e) => {
								e.preventDefault()
								onPostLike(props.post.id)
							}}>
							<span style={{ color: "inherit", fontSize: "1.2em" }}>
								<HeartFilledSVG />
							</span>
							<small className="ms-1" style={{ color: "inherit" }}>
								{props.post.likes}
							</small>
						</a>
					) : (
						<a
							href="#"
							style={{ color: "rgba(220, 220, 220, 1)" }}
							onClick={(e) => {
								e.preventDefault()
								onPostLike(props.post.id)
							}}>
							<span style={{ color: "inherit", fontSize: "1.2em" }}>
								<HeartSVG />
							</span>
							<small className="ms-1" style={{ color: "inherit" }}>
								{props.post.likes}
							</small>
						</a>
					)}

					{/* Post comments */}
					<Link href={"/post/" + props.post.id}>
						<a style={{ color: "rgba(220, 220, 220, 1)" }}>
							<span className="ms-5" style={{ fontSize: "1.2em" }}>
								<CommentSVG />
							</span>
							<small className="ms-1" style={{ color: "inherit" }}>
								{props.post.comments}
							</small>
						</a>
					</Link>

					{/* Share Post */}
					<span
						className="ms-5"
						style={{
							fontSize: "1.3em",
							color: "rgba(220, 220, 220, 1)",
							cursor: "pointer",
						}}
						onClick={() => onShare(props.post)}>
						<ShareSVG />
					</span>

					{/* <!-- Default dropup button --> */}
					<div className="dropup-center dropup hidden float-end">
						<a
							href="#"
							role="button"
							data-bs-toggle="dropdown"
							aria-expanded="false">
							<OptionsSVG />
						</a>
						<div
							className="dropdown-menu dropdown-menu-right"
							style={{ borderRadius: "0", backgroundColor: "#232323" }}>
							{props.post.username != props.auth?.username ? (
								props.post.username != "@blackmusic" && (
									<span>
										<a
											href="#"
											className="dropdown-item"
											onClick={(e) => {
												e.preventDefault()
												onMute()
											}}>
											<h6>
												{hasMuted
													? `Unmute ${props.post.username}`
													: `Mute ${props.post.username}`}
											</h6>
										</a>
										<a
											href="#"
											className="dropdown-item"
											onClick={(e) => {
												e.preventDefault()
												onFollow()
											}}>
											<h6>
												{hasFollowed
													? `Unfollow ${props.post.username}`
													: `Follow ${props.post.username}`}
											</h6>
										</a>
									</span>
								)
							) : (
								<span>
									<Link href={`/post/edit/${props.post.id}`}>
										<a className="dropdown-item">
											<h6>Edit post</h6>
										</a>
									</Link>
									<a
										href="#"
										className="dropdown-item"
										onClick={(e) => {
											e.preventDefault()
											props.onDeletePost(props.post.id)
										}}>
										<h6>Delete post</h6>
									</a>
								</span>
							)}
						</div>
					</div>
					{/* For small screens */}
					<div className="float-end anti-hidden">
						<span
							className="text-secondary"
							onClick={() => setBottomMenu("menu-open")}>
							<OptionsSVG />
						</span>
					</div>
					{/* Edited */}
					<small>
						<b>
							<i className="d-block text-secondary my-1">
								{props.post.hasEdited && "Edited"}
							</i>
						</b>
					</small>
				</div>
			</div>

			{/* Sliding Bottom Nav */}
			<div className={bottomMenu} onClick={() => setBottomMenu("")}>
				<div className="bottomMenu" style={{ margin: "5% 3%" }}>
					<div className="d-flex align-items-center justify-content-between border-bottom border-dark">
						<div></div>
						{/* <!-- Close Icon --> */}
						<div
							className="closeIcon float-end mr-3"
							style={{ fontSize: "0.8em" }}>
							<CloseSVG />
						</div>
					</div>

					{props.post.username != props.auth?.username ? (
						props.post.username != "@blackmusic" && (
							<div>
								<div onClick={onMute}>
									<h6 className="pb-2">
										{props.post.hasMuted
											? `Unmute ${props.post.username}`
											: `Mute ${props.post.username}`}
									</h6>
								</div>
								<div onClick={onFollow}>
									<h6 className="pb-2">
										{props.post.hasFollowed
											? `Unfollow ${props.post.username}`
											: `Follow ${props.post.username}`}
									</h6>
								</div>
							</div>
						)
					) : (
						<div>
							<Link href={`/post/edit/${props.post.id}`}>
								<a>
									<h6 className="pb-2">Edit post</h6>
								</a>
							</Link>
							<div onClick={() => props.onDeletePost(props.post.id)}>
								<h6 className="pb-2">Delete post</h6>
							</div>
						</div>
					)}
				</div>
			</div>
			{/* Sliding Bottom Nav End */}
		</div>
	)
}

export default PostMedia
