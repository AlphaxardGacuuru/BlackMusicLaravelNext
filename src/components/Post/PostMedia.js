import Link from 'next/link'
import axios from '@/lib/axios'

import Img from '@/components/core/Img'
import Poll from './Poll'

import DecoSVG from '../../svgs/DecoSVG'
import OptionsSVG from '../../svgs/OptionsSVG'
import CommentSVG from '../../svgs/CommentSVG'
import HeartSVG from '../../svgs/HeartSVG'
import HeartFilledSVG from '../../svgs/HeartFilledSVG'
import ShareSVG from '../../svgs/ShareSVG'
import Image from 'next/image'

const PostMedia = (props) => {

	// Function for voting in poll
	const onPoll = (post, parameter) => {
		axios.post(`/api/polls`, {
			post: post,
			parameter: parameter
		}).then((res) => {
			props.setMessages([res.data])
			// Update posts
			props.get("posts", props.setPosts, "posts")
		}).catch((err) => props.getErrors(err, true))
	}

	// Function for liking posts
	const onPostLike = (post) => {
		// Show like
		const newPosts = props.posts
			.filter((item) => {
				// Get the exact post and change like status
				if (item.id == post) {
					item.hasLiked = !item.hasLiked
				}
				return true
			})
		// Set new posts
		props.setPosts(newPosts)

		// Add like to database
		axios.post(`/api/post-likes`, {
			post: post
		}).then((res) => {
			props.setMessages([res.data])
			// Update posts
			props.get("posts", props.setPosts, "posts")
		}).catch((err) => props.getErrors(err))
	}

	// Web Share API for share button
	// Share must be triggered by "user activation"
	const onShare = (post) => {
		// Define share data
		const shareData = {
			title: post.text,
			text: `Check out this post on Black Music\n`,
			url: `https://music.black.co.ke/#/post-show/${post.id}`
		}
		// Check if data is shareble
		navigator.canShare(shareData) &&
			navigator.share(shareData)
	}

	return (
		<div className="d-flex">
			<div className="p-1">
				<div className="avatar-thumbnail-xs" style={{ borderRadius: "50%" }}>
					<Link href={`/profile/${props.post.username}`}>
						<a>
							<Img src={props.post.avatar}
								width="50px"
								height="50px"
								alt={'avatar'} />
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
						<small className="ms-1" style={{ color: "inherit" }}>{props.post.decos}</small>
					</span>
					<small><b><i className="float-end text-secondary me-1">{props.post.created_at}</i></b></small>
				</h6>
				<Link href={"post-show/" + props.post.id}>
					<p className="mb-0">{props.post.text}</p>
				</Link>

				{/* Show media */}
				<div className="mb-1" style={{ overflow: "hidden" }}>
					{props.post.media &&
						<Img
							src={props.post.media}
							width="100%"
							height="20em"
							alt="post-media" />}
				</div>

				{/* Polls */}
				{/* Parameter 1 */}
				<Poll
					{...props}
					parameter={props.post.parameter_1}
					hasVoted={props.post.hasVoted1}
					width={`${props.post.percentage1}%`}
					bgColor={props.post.parameter_1 == props.post.winner ? "#FFD700" : "#232323"}
					bgColor2={props.post.parameter_1 == props.post.winner ? "#FFD700" : "grey"}
					text={`${props.post.parameter_1} - ${props.post.percentage1} %`}
					onPoll={onPoll} />

				{/* Parameter 2 */}
				<Poll
					{...props}
					parameter={props.post.parameter_2}
					hasVoted={props.post.hasVoted2}
					width={`${props.post.percentage2}%`}
					bgColor={props.post.parameter_2 == props.post.winner ? "#FFD700" : "#232323"}
					bgColor2={props.post.parameter_2 == props.post.winner ? "#FFD700" : "grey"}
					text={`${props.post.parameter_2} - ${props.post.percentage2} %`}
					onPoll={onPoll} />

				{/* Parameter 3 */}
				<Poll
					{...props}
					parameter={props.post.parameter_3}
					hasVoted={props.post.hasVoted3}
					width={`${props.post.percentage3}%`}
					bgColor={props.post.parameter_3 == props.post.winner ? "#FFD700" : "#232323"}
					bgColor2={props.post.parameter_3 == props.post.winner ? "#FFD700" : "grey"}
					text={`${props.post.parameter_3} - ${props.post.percentage3} %`}
					onPoll={onPoll} />

				{/* Parameter 4 */}
				<Poll
					{...props}
					parameter={props.post.parameter_4}
					hasVoted={props.post.hasVoted4}
					width={`${props.post.percentage4}%`}
					bgColor={props.post.parameter_4 == props.post.winner ? "#FFD700" : "#232323"}
					bgColor2={props.post.parameter_4 == props.post.winner ? "#FFD700" : "grey"}
					text={`${props.post.parameter_4} - ${props.post.percentage4} %`}
					onPoll={onPoll} />

				{/* Parameter 5 */}
				<Poll
					{...props}
					parameter={props.post.parameter_5}
					hasVoted={props.post.hasVoted5}
					width={`${props.post.percentage5}%`}
					bgColor={props.post.parameter_4 == props.post.winner ? "#FFD700" : "#232323"}
					bgColor2={props.post.parameter_4 == props.post.winner ? "#FFD700" : "grey"}
					text={`${props.post.parameter_5} - ${props.post.percentage5} %`}
					onPoll={onPoll} />

				{/* Total votes */}
				{props.post.parameter_1 ?
					props.post.username == props.auth?.username || !props.post.isWithin24Hrs ?
						<small style={{ color: "grey" }}>
							<i>Total votes: {props.post.totalVotes}</i>
							<br />
						</small> : ""
					: ""}
				{/* Polls End */}

				{/* Post likes */}
				{props.post.hasLiked ?
					<a href="#"
						style={{ color: "#fb3958" }}
						onClick={(e) => {
							e.preventDefault()
							onPostLike(props.post.id)
						}}>
						<span style={{ color: "inherit", fontSize: "1.2em" }}><HeartFilledSVG /></span>
						<small className="ms-1" style={{ color: "inherit" }}>{props.post.likes}</small>
					</a> :
					<a
						href="#"
						style={{ color: "rgba(220, 220, 220, 1)" }}
						onClick={(e) => {
							e.preventDefault()
							onPostLike(props.post.id)
						}}>
						<span style={{ color: "inherit", fontSize: "1.2em" }}><HeartSVG /></span>
						<small className="ms-1" style={{ color: "inherit" }}>{props.post.likes}</small>
					</a>}

				{/* Post comments */}
				<Link href={"/post-show/" + props.post.id}>
					<a style={{ color: "rgba(220, 220, 220, 1)" }}>
						<span className="ms-5" style={{ fontSize: "1.2em" }}><CommentSVG /></span>
						<small className="ms-1" style={{ color: "inherit" }}>{props.post.comments}</small>
					</a>
				</Link>

				{/* Share Post */}
				<span
					className="ms-5"
					style={{ fontSize: "1.3em", color: "rgba(220, 220, 220, 1)" }}
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
					<div className="dropdown-menu dropdown-menu-right"
						style={{ borderRadius: "0", backgroundColor: "#232323" }}>
						{props.post.username != props.auth?.username ?
							props.post.username != "@blackmusic" &&
							<a href="#" className="dropdown-item" onClick={(e) => {
								e.preventDefault()
								props.onFollow(props.post.username)
							}}>
								<h6>
									{props.post.hasFollowed ?
										`Unfollow ${props.post.username}` :
										`Follow ${props.post.username}`}
								</h6>
							</a> :
							<span>
								<Link href={`/post/${props.post.id}`}>
									<a className="dropdown-item">
										<h6>Edit post</h6>
									</a>
								</Link>
								<a
									href="#"
									className="dropdown-item"
									onClick={(e) => {
										e.preventDefault();
										props.onDeletePost(props.post.id)
									}}>
									<h6>Delete post</h6>
								</a>
							</span>}
					</div>
				</div>
				{/* For small screens */}
				<div className="float-end anti-hidden">
					<span
						className="text-secondary"
						onClick={() => {
							if (props.post.username != props.auth?.username) {
								if (props.post.username != "@blackmusic") {
									props.setBottomMenu("menu-open")
									props.setUserToUnfollow(props.post.username)
									// Show and Hide elements
									props.setUnfollowLink(true)
									props.setDeleteLink(false)
									props.setEditLink(false)
								}
							} else {
								props.setBottomMenu("menu-open")
								props.setPostToEdit(props.post.id)
								// Show and Hide elements
								props.setEditLink(true)
								props.setDeleteLink(true)
								props.setUnfollowLink(false)
							}
						}}>
						<OptionsSVG />
					</span>
				</div>
				{/* Edited */}
				<small>
					<b><i className="d-block text-secondary my-1">{props.post.hasEdited && "Edited"}</i></b>
				</small>
			</div>
		</div>
	)
}

export default PostMedia