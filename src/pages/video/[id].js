import React, { useState, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'
import axios from '@/lib/axios'

import onCartVideos from '@/functions/onCartVideos'

import Btn from '@/components/Core/Btn'
import Img from '@/components/Core/Img'
import PostOptions from '@/components/Post/PostOptions';
import CommentMedia from '@/components/Core/CommentMedia';
import VideoMedia from '@/components/Video/VideoMedia'
import SocialMediaInput from '@/components/Core/SocialMediaInput'

import ShareSVG from '@/svgs/ShareSVG'
import CartSVG from '@/svgs/CartSVG'
import CheckSVG from '@/svgs/CheckSVG'
import HeartFilledSVG from '@/svgs/HeartFilledSVG'
import HeartSVG from '@/svgs/HeartSVG'
import DecoSVG from '@/svgs/DecoSVG'

const VideoShow = (props) => {

	// let { referer } = router.query
	const router = useRouter()

	let { id } = router.query

	const [video, setVideo] = useState({})
	const [tabClass, setTabClass] = useState("comments")
	const [bottomMenu, setBottomMenu] = useState("")
	const [commentToEdit, setCommentToEdit] = useState()
	const [commentDeleteLink, setCommentDeleteLink] = useState()

	useEffect(() => {

		setVideo(props.data.video[0])
		props.setVideoComments(props.data.comments)

		// Set states
		setTimeout(() => {
			props.setPlaceholder("Add a comment")
			props.setText("")
			props.setId(id)
			props.setShowImage(false)
			props.setShowPoll(false)
			props.setShowEmojiPicker(false)
			props.setShowImagePicker(false)
			props.setShowPollPicker(false)
			props.setUrlTo("video-comments")
			props.setUrlToTwo(`video-comments/${id}`)
			props.setStateToUpdate(() => props.setVideoComments)
			props.setStateToUpdateTwo(() => props.setVideoComments)
			props.setEditing(false)
		}, 1000)
	}, [id])


	// Function for liking video
	const onVideoLike = () => {
		// Show like
		video.hasLiked = !video.hasLiked

		// Add like to database
		axios.post(`/api/video-likes`, {
			video: id
		}).then((res) => {
			props.setMessages([res.data])
			// Fetch Video
			axios.get(`/api/videos/${id}`)
				.then((res) => setVideo(res.data[0]))
		}).catch((err) => props.getErrors(err))
	}

	// Function for following users
	const onFollow = (username) => {
		// Change follow button
		video.hasFollowed = !video.hasFollowed

		// Add follow
		axios.post(`/api/follows`, { musician: username })
			.then((res) => {
				props.setMessages([res.data])
				// Update users
				props.get("users", props.setUsers, "users")
				// Update posts
				props.get("posts", props.setPosts, "posts")
			}).catch((err) => props.getErrors(err, true))
	}

	// Function for liking comments
	const onCommentLike = (comment) => {
		// Show like
		const newVideoComments = props.videoComments
			.filter((item) => {
				// Get the exact video and change like status
				if (item.id == comment) {
					item.hasLiked = !item.hasLiked
				}
				return true
			})
		// Set new videos
		props.setVideoComments(newVideoComments)

		// Add like to database
		axios.post(`/api/video-comment-likes`, {
			comment: comment
		}).then((res) => {
			props.setMessages([res.data])
			// Update Video Comments
			props.get(`video-comments/${id}`, props.setVideoComments)
		}).catch((err) => props.getErrors(err))
	}

	// Function for deleting comments
	const onDeleteComment = (comment) => {
		axios.delete(`/api/video-comments/${comment}`)
			.then((res) => {
				props.setMessages([res.data])
				// Update Video Comments
				props.get(`video-comments/${id}`, props.setVideoComments)
			}).catch((err) => props.getErrors(err))
	}

	// Buy function
	const onBuyVideos = (video) => {
		onCartVideos(props, video)
		setTimeout(() => router.push('/cart'), 500)
	}

	// Function for downloading audio
	const onDownload = () => {
		window.open(`${props.url}/api/videos/download/${video.id}`)
		props.setMessages([`Downloading ${video.name}`])
	}

	// Web Share API for share button
	// Share must be triggered by "user activation"
	const onShare = () => {
		// Define share data
		const shareData = {
			title: video.name,
			text: `Check out ${video.name} on Black Music\n`,
			url: `https://music.black.co.ke/#/video/${id}/${props.auth.username}`
		}
		// Check if data is shareble
		navigator.canShare(shareData) &&
			navigator.share(shareData)
	}

	// const onGuestBuy = () => {
	// props.setLogin(true)
	// sessionStorage.setItem("referer", referer)
	// sessionStorage.setItem("page", location.pathname)
	// }

	return (
		<>
			<div className="row">
				<div className="col-sm-1"></div>
				<div className="col-sm-7">
					{video.video ?
						video.video.match(/https/) ?
							<div className="resp-container">
								<iframe className='resp-iframe'
									width='880px'
									height='495px'
									src={video.hasBoughtVideo ?
										`${video.video}/?autoplay=1` :
										`${video.video}?autoplay=1&end=10&controls=0`}
									frameBorder='0'
									allow='accelerometer'
									encrypted-media="true"
									gyroscope="true"
									picture-in-picture="true"
									allowFullScreen>
								</iframe>
							</div> :
							<div className="resp-container">
								<video
									className="resp-iframe"
									width="880px"
									height="495px"
									controls={video.hasBoughtVideo && true}
									controlsList="nodownload"
									autoPlay>
									<source
										src={video.hasBoughtVideo ?
											`${video.video}` :
											`${video.video}#t=1,10`}
										type="video/mp4" />
								</video>
							</div> : ""}

					{/* Video Info Area */}
					<div className="d-flex justify-content-between">
						{/* Video likes */}
						<div className="p-2 me-2">
							{video.hasLiked ?
								<a href="#"
									className="fs-6"
									style={{ color: "#cc3300" }}
									onClick={(e) => {
										e.preventDefault()
										onVideoLike()
									}}>
									<HeartFilledSVG />
									<small className="ms-1" style={{ color: "inherit" }}>{video.likes}</small>
								</a> :
								<a href='#'
									className="fs-6"
									onClick={(e) => {
										e.preventDefault()
										onVideoLike()
									}}>
									<HeartSVG />
									<small className="ms-1" style={{ color: "inherit" }}>{video.likes}</small>
								</a>}
						</div>

						{/* Share button */}
						<div className="p-2">
							<a href="#"
								onClick={(e) => {
									e.preventDefault()
									props.auth.username != "@guest" && onShare()
								}}>
								<span className="fs-5"><ShareSVG /></span>
								<span className="ms-1">SHARE</span>
							</a>
						</div>

						{/* Download/Buy button */}
						{video.hasBoughtVideo ?
							// Ensure video is downloadable
							!video.video.match(/https/) &&
							<div className="p-2">
								<Btn
									btnClass="mysonar-btn white-btn"
									btnText="download"
									onClick={onDownload} />
							</div> :
							// Cart Btn
							video.inCart ?
								<div className="p-2">
									<button className="mysonar-btn white-btn mb-1"
										style={{ minWidth: '90px', height: '33px' }}
										onClick={() => props.onCartVideos(id)}>
										<CartSVG />
									</button>
								</div> :
								<div className="p-2">
									<Btn
										btnClass="mysonar-btn green-btn btn-2"
										btnText="KES 20"
										onClick={() => {
											// If user is guest then redirect to Login
											props.auth.username == "@guest" ?
												onGuestBuy() :
												onBuyVideos(id)
										}} />
								</div>}
					</div>

					<div className="d-flex flex-row">
						<div className="p-2 me-auto">
							<h6 className="m-0 p-0"
								style={{
									width: "300px",
									whiteSpace: "nowrap",
									overflow: "hidden",
									textOverflow: "clip"
								}}>
								{video.name}
							</h6>
							<h6>{video.album}</h6>
							<h6>{video.genre}</h6>
							<h6>{video.createdAt}</h6>
						</div>
					</div>
					{/* Video Info Area End */}

					{/* <!-- Read more section --> */}

					{/* {{-- Collapse --}} */}
					<div className="p-2 border-bottom border-dark">
						<button
							className="mysonar-btn white-btn"
							type="button"
							data-bs-toggle="collapse"
							data-bs-target="#collapseExample"
							aria-expanded="false"
							aria-controls="collapseExample">
							read more
						</button>
						<div className="collapse" id="collapseExample">
							<div className="p-2 text-white">
								{video.description}
							</div>
						</div>
					</div>
					{/* {{-- Collapse End --}} */}

					{/* Artist Area */}
					<div className="p-2 border-bottom border-dark">
						<div className="d-flex">
							<div className="p-2">
								<Link href={`/profile/${video.username}`}>
									<a>
										<Img
											src={video.avatar}
											className="rounded-circle"
											width="30px"
											height="30px"
											alt="user"
											loading="lazy" />
									</a>
								</Link>
							</div>
							<div className="p-2" style={{ width: "50%" }}>
								<Link href={`/profile/${video.username}`}>
									<a>
										<div style={{
											// width: "50%",
											// whiteSpace: "nowrap",
											overflow: "hidden",
											textOverflow: "clip"
										}}>
											<b className="ml-2">{video.artistName}</b>
											<small><i>{video.username}</i></small>
											<span className="ms-1" style={{ color: "gold" }}>
												<DecoSVG />
												<small className="ms-1" style={{ color: "inherit" }}>
													{video.artistDecos}
												</small>
											</span>
										</div>
									</a>
								</Link>
							</div>
							<div className="p-2 text-end flex-grow-1">
								{/* Check whether user has bought at least one song from user */}
								{/* Check whether user has followed user and display appropriate button */}
								{video.hasBought1 || props.auth?.username == "@blackmusic" ?
									video.hasFollowed ?
										<button
											className={'btn float-right rounded-0 text-light'}
											style={{ backgroundColor: "#232323" }}
											onClick={() => onFollow(video.username)}>
											Followed
											<CheckSVG />
										</button>
										: <Btn btnClass={'mysonar-btn white-btn float-right'}
											onClick={() => onFollow(video.username)}
											btnText="follow" />
									: <Btn btnClass={'mysonar-btn white-btn float-right'}
										onClick={() =>
											props.setErrors([`You must have bought atleast one song by ${video.username}`])}
										btnText="follow" />}
							</div>
						</div>
					</div>
					{/* Artist Area End */}

					<br />

					{/* Tab for Comment and Up Next */}
					<div className="d-flex">
						<div className="p-2 flex-fill anti-hidden">
							<h6 className={tabClass == "comments" ? "active-scrollmenu" : "p-2"}
								onClick={() => setTabClass("comments")}>
								<center>Comments</center>
							</h6>
						</div>
						<div className="p-2 flex-fill anti-hidden">
							<h6 className={tabClass == "recommended" ? "active-scrollmenu" : "p-1"}
								onClick={() => setTabClass("recommended")}>
								<center>Recommended</center>
							</h6>
						</div>
					</div>

					{/* <!-- Comment Form ---> */}
					<div className={tabClass == "comments" ? "" : "hidden"}>
						{video.username == props.auth.username ||
							props.auth.username == "@blackmusic" ||
							video.hasBoughtVideo ?
							<form
								onSubmit={props.onSubmit}
								className="contact-form bg-white mb-2"
								autoComplete="off">
								<SocialMediaInput {...props} />
							</form> : ""}
						{/* <!-- End of Comment Form --> */}
						<br />

						{/* <!-- Comment Section --> */}
						{video.username == props.auth.username ||
							props.auth.username == "@blackmusic" ||
							video.hasBoughtVideo ?
							// Check if video comments exist
							props.videoComments.length > 0 ?
								props.videoComments
									.map((comment, key) => (
										<CommentMedia
											{...props}
											key={key}
											comment={comment}
											setBottomMenu={setBottomMenu}
											setCommentDeleteLink={setCommentDeleteLink}
											setCommentToEdit={setCommentToEdit}
											onCommentLike={onCommentLike}
											onDeleteComment={onDeleteComment} />
									)) :
								<center className="my-3">
									<h6 style={{ color: "grey" }}>No comments to show</h6>
								</center> : ""}
					</div>
				</div>
				{/* <!-- End of Comment Section --> */}

				{/* -- Up next area -- */}
				<div className={tabClass == "recommended" ? "col-sm-3" : "col-sm-3 hidden"}>
					<div className="p-2">
						<h5>Up next</h5>
					</div>
					{!props.boughtVideos
						.some((boughtVideo) => boughtVideo.username == props.auth.username) &&
						<center>
							<h6 style={{ color: "grey" }}>You haven't bought any videos</h6>
						</center>}

					{props.boughtVideos
						.filter((boughtVideo) => {
							return boughtVideo.username == props.auth.username &&
								boughtVideo.video_id != id
						}).map((boughtVideo, key) => (
							<VideoMedia
								{...props}
								video={boughtVideo}
								onBuyVideos={onBuyVideos}
								onClick={() => props.setShow(0)} />
						))}
					{/* <!-- End of Up next Area --> */}

					{/* Songs to watch Area */}
					<div className="p-2 mt-5">
						<h5>Songs to watch</h5>
					</div>
					{props.videos
						.filter((video) => {
							return !video.hasBoughtVideo &&
								video.username != props.auth.username &&
								video.id != id
						}).slice(0, 10)
						.map((video, key) => (
							<VideoMedia
								key={key}
								{...props}
								video={video}
								onBuyVideos={onBuyVideos}
								onClick={() => props.setShow(0)} />
						))}
				</div>
				<div className="col-sm-1"></div>
			</div>

			{/* Sliding Bottom Nav */}
			<PostOptions
				{...props}
				bottomMenu={bottomMenu}
				setBottomMenu={setBottomMenu}
				commentToEdit={commentToEdit}
				commentDeleteLink={commentDeleteLink}
				onDeleteComment={onDeleteComment} />
			{/* Sliding Bottom Nav end */}
		</>
	)
}

// This gets called on every request
export async function getServerSideProps(context) {

	const { id } = context.query;

	var data = {
		video: null,
		comments: null
	}

	// Fetch Video
	await axios.get(`/api/videos/${id}`)
		.then((res) => data.video = res.data)

	// Fetch Video Comments
	await axios.get(`/api/video-comments/${id}`)
		.then((res) => data.comments = res.data)

	// Pass data to the page via props
	return { props: { data } }
}

export default VideoShow
