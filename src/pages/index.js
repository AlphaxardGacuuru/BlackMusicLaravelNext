import React, { useState, useEffect, Suspense } from "react"
import { useRouter } from "next/router"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "@/components/Core/Img"

import LoadingMusicianMedia from "@/components/User/LoadingMusicianMedia"
import LoadingVideoMedia from "@/components/Video/LoadingVideoMedia"
import LoadingPostMedia from "@/components/Post/LoadingPostMedia"
import VideoMedia from "@/components/Video/VideoMedia"
import MusicianMedia from "@/components/User/MusicianMedia"
import PostMedia from "@/components/Post/PostMedia"

import PenSVG from "@/svgs/PenSVG"
import ChatSVG from "@/svgs/ChatSVG"
import DecoSVG from "@/svgs/DecoSVG"
import PostOptions from "@/components/Post/PostOptions"

export default function Home(props) {
	const [videoSlice, setVideoSlice] = useState(10)
	const [bottomMenu, setBottomMenu] = useState("")
	const [userToUnfollow, setUserToUnfollow] = useState()
	const [postToEdit, setPostToEdit] = useState()
	const [editLink, setEditLink] = useState()
	const [deleteLink, setDeleteLink] = useState()
	const [unfollowLink, setUnfollowLink] = useState()
	const [showPostBtn, setShowPostBtn] = useState()

	const router = useRouter()

	useEffect(() => {
		props.auth?.account_type == "musician" && setShowPostBtn(true)
	}, [props.auth])

	// Function for deleting posts
	const onDeletePost = (id) => {
		axios
			.delete(`/api/posts/${id}`)
			.then((res) => {
				props.setMessages([res.data])
				// Update posts
				props.get("posts", props.setPosts, "posts")
			})
			.catch((err) => props.getErrors(err, true))
	}

	// Function for loading more artists
	const handleScroll = (e) => {
		const bottom =
			e.target.scrollLeft >= e.target.scrollWidth - e.target.scrollWidth / 3

		if (bottom) {
			setVideoSlice(videoSlice + 10)
		}
	}

	// Random array for dummy loading elements
	const dummyArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

	var raise =
		props.audioStates.show.id != 0 && props.audioStates.show.id != undefined

	return (
		<>
			{/* Post button */}
			{showPostBtn && (
				<Link href="post/create">
					<a id="floatBtn" className={raise ? "mb-5" : undefined}>
						<PenSVG />
					</a>
				</Link>
			)}

			{/* Chat button */}
			<Link href="/chat">
				<a id="chatFloatBtn" className={raise ? "mb-5" : undefined}>
					<ChatSVG />
				</a>
			</Link>

			{/* <!-- Profile info area --> */}
			<div className="row">
				<div className="col-sm-1 hidden"></div>
				<div className="col-sm-3 hidden">
					<div className="d-flex">
						<div className="p-2">
							<div
								className="avatar-thumbnail-sm"
								style={{ borderRadius: "50%" }}>
								<Link href={`/profile/${props.auth?.username}`}>
									<a>
										<Img
											src={props.auth?.avatar}
											width="100px"
											height="100px"
											alt="avatar"
										/>
									</a>
								</Link>
							</div>
						</div>
						<div className="p-2 flex-grow-1">
							<h5
								className="m-0 p-0"
								style={{
									width: "160px",
									whiteSpace: "nowrap",
									overflow: "hidden",
									textOverflow: "clip",
								}}>
								{props.auth?.name}
							</h5>
							<h6
								className="m-0 p-0"
								style={{
									width: "140px",
									whiteSpace: "nowrap",
									overflow: "hidden",
									textOverflow: "clip",
								}}>
								<small>{props.auth?.username}</small>
							</h6>
							<span style={{ color: "gold" }}>
								<DecoSVG />
								<small
									className="ms-1 fw-lighter align-bottom"
									style={{ color: "inherit" }}>
									{props.auth?.decos}
								</small>
							</span>
						</div>
					</div>
					<div className="d-flex">
						<div className="p-2 flex-fill">
							<h6>Posts</h6>
							<span style={{ color: "rgba(220, 220, 220, 1)" }}>
								{props.auth?.posts}
							</span>
							<br />
						</div>
						<div className="p-2 flex-fill">
							<h6>Fans</h6>
							<span style={{ color: "rgba(220, 220, 220, 1)" }}>
								{props.auth?.fans}
							</span>
							<br />
						</div>
					</div>
					{/* <!-- Profile info area End --> */}

					<br />

					{/* <!-- Musicians suggestions area --> */}
					<div>
						<div className="p-2">
							<h2>Musicians to follow</h2>
						</div>
						{/* Slice to limit to 10 */}

						{/* Loading Musician items */}
						{dummyArray
							.filter(
								() => props.users.filter((user) => user.account_type).length < 1
							)
							.map((item, key) => (
								<LoadingMusicianMedia key={key} />
							))}

						{/* Musicians */}
						{props.users
							.filter(
								(user) =>
									user.account_type == "musician" &&
									user.username != props.auth?.username &&
									user.username != "@blackmusic"
							)
							.slice(0, 10)
							.map((user, key) => (
								<Suspense key={key} fallback={<LoadingMusicianMedia />}>
									<MusicianMedia {...props} user={user} />
								</Suspense>
							))}
					</div>
				</div>
				{/* <!-- Musician suggestion area end --> */}

				{/* <!-- ****** Songs Area ****** --> */}
				<div className="col-sm-4">
					<div className="mb-2 border-bottom border-secondary">
						<h5>Songs for you</h5>
						<div className="hidden-scroll pb-2" onScroll={handleScroll}>
							{/* Loading Video items */}
							{dummyArray
								.filter(() => props.videos.length < 1)
								.map((item, key) => (
									<LoadingVideoMedia key={key} />
								))}

							{/* Real Video items */}
							{props.videos
								.filter((video) => !video.hasBoughtVideo)
								.slice(0, videoSlice)
								.map((video, key) => (
									<Suspense key={key} fallback={<LoadingVideoMedia />}>
										<VideoMedia
											{...props}
											video={video}
											onClick={() => props.setShow(0)}
										/>
									</Suspense>
								))}
						</div>
					</div>
					{/* <!-- ****** Songs Area End ****** --> */}

					{/* <!-- Posts area --> */}
					<div className="m-0 p-0">
						{/* Loading Post items */}
						{dummyArray
							.filter(() => props.posts.length < 1)
							.map((item, key) => (
								<LoadingPostMedia key={key} />
							))}

						{/* Posts */}
						{props.posts
							.filter(
								(post) =>
									post.hasFollowed || props.auth?.username == "@blackmusic"
							)
							.map((post, key) => (
								<Suspense key={key} fallback={<LoadingPostMedia />}>
									<PostMedia
										{...props}
										post={post}
										setBottomMenu={setBottomMenu}
										setUserToUnfollow={setUserToUnfollow}
										setPostToEdit={setPostToEdit}
										setEditLink={setEditLink}
										setDeleteLink={setDeleteLink}
										onDeletePost={onDeletePost}
										setUnfollowLink={setUnfollowLink}
									/>
								</Suspense>
							))}
					</div>
				</div>
				{/* <!-- Posts area end --> */}

				{/* <!-- Song suggestion area --> */}
				<div className="col-sm-3 hidden">
					<div className="p-2">
						<h5>Songs to watch</h5>
					</div>
					<div className=" m-0 p-0">
						{/* Loading Video items */}
						{dummyArray
							.filter(() => props.videos.length < 1)
							.map((item, key) => (
								<LoadingVideoMedia key={key} />
							))}

						{/* Real Video items */}
						{props.videos
							.filter((video) => !video.hasBoughtVideo)
							.slice(0, 10)
							.map((video, key) => (
								<Suspense key={key} fallback={<LoadingVideoMedia />}>
									<VideoMedia {...props} video={video} />
								</Suspense>
							))}
					</div>
				</div>
				{/* <!-- End of Song Suggestion Area --> */}

				<div className="col-sm-1"></div>
			</div>

			{/* Sliding Bottom Nav */}
			<PostOptions
				{...props}
				bottomMenu={bottomMenu}
				setBottomMenu={setBottomMenu}
				unfollowLink={unfollowLink}
				userToUnfollow={userToUnfollow}
				editLink={editLink}
				postToEdit={postToEdit}
				deleteLink={deleteLink}
				onDeletePost={onDeletePost}
			/>
			{/* Sliding Bottom Nav end */}
		</>
	)
}
