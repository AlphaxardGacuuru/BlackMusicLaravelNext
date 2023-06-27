import React, { useEffect, useState } from "react"
import { useRouter } from "next/router"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "next/image"
import Btn from "../../components/Core/Btn"

import CheckSVG from "../../svgs/CheckSVG"
import DecoSVG from "../../svgs/DecoSVG"
import PostMedia from "../../components/Post/PostMedia"
import ssrAxios from "@/lib/ssrAxios"

import VideoMedia from "@/components/Video/VideoMedia"
import AudioMedia from "@/components/Audio/AudioMedia"

const Profile = (props) => {
	const router = useRouter()

	let { username } = router.query

	const [user, setUser] = useState(props.user)
	const [artistVideoAlbums, setArtistVideoAlbums] = useState(
		props.artistVideoAlbums
	)
	const [artistVideos, setVideos] = useState(props.artistVideos)
	const [artistPosts, setArtistPosts] = useState(props.artistPosts)
	const [artistAudioAlbums, setArtistAudioAlbums] = useState(
		props.artistAudioAlbums
	)
	const [artistAudios, setAudios] = useState(props.artistAudios)

	const [tabClass, setTabClass] = useState("videos")

	useEffect(() => {
		props.get(`users/${username}`, setUser)
		props.get(`artist/video-albums/${username}`, setArtistVideoAlbums)
		props.get(`artist/videos/${username}`, setVideos, "artistVideos", false)
		props.get(`artist/posts/${username}`, setArtistPosts)
		props.get(`artist/audio-albums/${username}`, setArtistAudioAlbums)
		props.get(`artist/audios/${username}`, setAudios)
	}, [])

	/*
	 * Function for following Musicans */
	const onFollow = () => {
		// Add follow
		axios
			.post(`/api/follows`, { musician: user.username })
			.then((res) => {
				props.setMessages([res.data.message])
				// Update User info
				props.get(`users/${username}`, setUser)
				props.get(`artist/posts/${username}`, setArtistPosts)
			})
			.catch((err) => props.getErrors(err, true))
	}

	// Function for deleting posts
	const onDeletePost = (id) => {
		// Remove deleted post
		setDeletedIds([...deletedIds, id])

		axios
			.delete(`/api/posts/${id}`)
			.then((res) => props.setMessages([res.data.message]))
			.catch((err) => props.getErrors(err, true))
	}

	return (
		<>
			<div
				className="row p-0 m-0"
				style={{
					backgroundImage: `url('${user.backdrop}')`,
					backgroundPosition: "center",
					backgroundSize: "cover",
					position: "relative",
					height: "100%",
				}}>
				{/* Profile pic and background area */}
				<div className="col-sm-12 p-0">
					<br />
					<br className="hidden" />
					<div>
						<div
							className="avatar-container"
							style={{
								marginTop: "100px",
								top: "70px",
								left: "10px",
							}}>
							<Img
								style={{
									position: "absolute",
									zIndex: "99",
								}}
								className="avatar hover-img"
								src={user.avatar}
								layout="fill"
							/>
						</div>
					</div>
				</div>
				{/* Profile pic and background area End */}
			</div>

			{/* Profile Area */}
			<div className="row border-bottom border-dark">
				<div className="col-sm-1"></div>
				<div className="col-sm-10">
					<br />
					<br />
					<br className="anti-hidden" />
					{/* Edit and Follow button */}
					{user.username == props.auth?.username ? (
						<Link href="/profile/edit">
							<a>
								<Btn
									btnClass="mysonar-btn white-btn float-end"
									btnText="edit profile"
								/>
							</a>
						</Link>
					) : (
						user.username != "@blackmusic" &&
						(user.hasBought1 || props.auth?.username == "@blackmusic" ? (
							user.hasFollowed ? (
								<Btn
									btnClass="mysonar-btn btn-2 float-end"
									btnStyle={{ lineHeight: "20px" }}
									onClick={() => onFollow(props, props.user.username)}
									btnText={
										<span>
											Followed
											<span className="fs-6" style={{ lineHeight: "10px" }}>
												<CheckSVG />
											</span>
										</span>
									}
								/>
							) : (
								<Btn
									btnClass="mysonar-btn white-btn float-end"
									onClick={onFollow}
									btnText="follow"
								/>
							)
						) : (
							<Btn
								btnClass="mysonar-btn white-btn float-end"
								onClick={() =>
									props.setErrors([
										`You must have bought atleast one song by ${username}`,
									])
								}
								btnText="follow"
							/>
						))
					)}
					{/* Edit and Follow button End */}
					<div>
						<h3>{user.name}</h3>
						<h5>
							{user.username}
							<span style={{ color: "gold" }} className="ms-2">
								<DecoSVG />
								<small className="ms-1">{user.decos}</small>
							</span>
						</h5>
						<h6>{user.bio}</h6>
					</div>
					<div className="d-flex flex-row">
						<div className="p-2">
							<span>Following</span>
							<br />
							<span>{user.following}</span>
						</div>
						<div className="p-2">
							<span>Fans</span>
							<br />
							<span>{user.fans}</span>
						</div>
					</div>
				</div>
				<div className="col-sm-1"></div>
			</div>
			{/* End of Profile Area */}

			{/* Tabs for Videos, Posts and Audios */}
			<div className="d-flex">
				<div className="p-2 flex-fill anti-hidden">
					<h4
						className={tabClass == "videos" ? "active-scrollmenu" : "p-1"}
						onClick={() => setTabClass("videos")}>
						<center>Videos</center>
					</h4>
				</div>
				<div className="p-2 flex-fill anti-hidden">
					<h4
						className={tabClass == "posts" ? "active-scrollmenu" : "p-1"}
						onClick={() => setTabClass("posts")}>
						<center>Posts</center>
					</h4>
				</div>
				<div className="p-2 flex-fill anti-hidden">
					<h4
						className={tabClass == "audios" ? "active-scrollmenu" : "p-1"}
						onClick={() => setTabClass("audios")}>
						<center>Audios</center>
					</h4>
				</div>
			</div>
			{/* Tabs for Videos, Posts and Audios End */}

			<div className="row">
				<div className="col-sm-1"></div>
				<div className={tabClass == "videos" ? "col-sm-3" : "col-sm-3 hidden"}>
					<center className="hidden">
						<h2>Videos</h2>
					</center>
					{artistVideoAlbums.length == 0 && (
						<center className="mt-3">
							<h6 style={{ color: "grey" }}>
								{username} does not have any videos
							</h6>
						</center>
					)}

					{/* Video Albums */}
					{artistVideoAlbums.map((videoAlbum, key) => (
						<div key={videoAlbum.id} className="mb-5">
							<div className="d-flex">
								<div className="p-2">
									<Img
										src={videoAlbum.cover}
										width="100px"
										height="100px"
										alt="album cover"
									/>
								</div>
								<div className="p-2">
									<small>Video Album</small>
									<h1>{videoAlbum.name}</h1>
									<h6>{videoAlbum.created_at}</h6>
								</div>
							</div>
							{artistVideos
								.filter((video) => video.videoAlbumId == videoAlbum.id)
								.map((video, index) => (
									<VideoMedia {...props} key={key} video={video} />
								))}
						</div>
					))}
					{/* Videos Albums End */}
				</div>

				<div className={tabClass == "posts" ? "col-sm-4" : "col-sm-4 hidden"}>
					<center className="hidden">
						<h2>Posts</h2>
					</center>
					{artistPosts.filter((post) => post.username == username).length ==
						0 && (
						<center>
							<h6 style={{ color: "grey" }}>
								{username} does not have any posts
							</h6>
						</center>
					)}

					{/* <!-- Posts area --> */}
					{artistPosts.map((post, key) => (
						<PostMedia
							{...props}
							key={key}
							post={post}
							onDeletePost={onDeletePost}
							stateToUpdate={() => {
								props.get(`users/${username}`, setUser)
								props.get(`artist/posts/${post.username}`, setArtistPosts)
							}}
						/>
					))}
				</div>
				{/* <!-- Posts area end --> */}
				<div className={tabClass == "audios" ? "col-sm-3" : "col-sm-3 hidden"}>
					<center className="hidden">
						<h2>Audios</h2>
					</center>
					{artistAudioAlbums.length == 0 && (
						<center className="mt-3">
							<h6 style={{ color: "grey" }}>
								{username} does not have any audios
							</h6>
						</center>
					)}

					{/* Audio Albums */}
					{artistAudioAlbums.map((audioAlbum, key) => (
						<div key={audioAlbum.id} className="mb-5">
							<div className="d-flex">
								<div className="p-2">
									<Img
										src={audioAlbum.cover}
										width="100px"
										height="100px"
										alt={"album cover"}
									/>
								</div>
								<div className="p-2">
									<small>Audio Album</small>
									<h1>{audioAlbum.name}</h1>
									<h6>{audioAlbum.created_at}</h6>
								</div>
							</div>
							{artistAudios
								.filter((audio) => audio.audioAlbumId == audioAlbum.id)
								.map((audio, key) => (
									<AudioMedia {...props} key={key} audio={audio} />
								))}
						</div>
					))}
					{/* Audio Albums End */}
				</div>
				<div className="col-sm-1"></div>
			</div>
		</>
	)
}

// This gets called on every request
export async function getServerSideProps(context) {
	const { username } = context.query

	var data = {
		user: {},
		artistVideoAlbums: {},
		artistVideos: {},
		artistPosts: {},
		artistAudioAlbums: {},
		artistAudios: {},
	}

	// Fetch User
	await ssrAxios
		.get(`/api/users/${username}`)
		.then((res) => (data.user = res.data.data))

	// Fetch Artist's Video Albums
	await ssrAxios
		.get(`/api/artist/video-albums/${username}`)
		.then((res) => (data.artistVideoAlbums = res.data.data))

	// Fetch Artist's Videos
	await ssrAxios
		.get(`/api/artist/videos/${username}`)
		.then((res) => (data.artistVideos = res.data.data))

	// Fetch Artist's Posts
	await ssrAxios
		.get(`/api/artist/posts/${username}`)
		.then((res) => (data.artistPosts = res.data.data))

	// Fetch Artist's Audio Albums
	await ssrAxios
		.get(`/api/artist/audio-albums/${username}`)
		.then((res) => (data.artistAudioAlbums = res.data.data))

	// Fetch Artist's Audios
	await ssrAxios
		.get(`/api/artist/audios/${username}`)
		.then((res) => (data.artistAudios = res.data.data))

	return { props: data }
}

export default Profile
