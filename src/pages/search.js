import React, { useState, useEffect } from 'react'
import axios from '@/lib/axios'

import Img from '@/components/core/Img'
import AvatarMedia from '@/components/User/AvatarMedia'
import VideoMedia from '@/components/Video/VideoMedia'
import AudioMedia from '@/components/Audio/AudioMedia'

const Search = (props) => {

	const [searchHistory, setSearchHistory] = useState(props.getLocalStorage("searchHistory"))

	// Fetch Search History
	useEffect(() => {
		axios.get(`/api/search`)
			.then((res) => {
				setSearchHistory(res.data)
				props.setLocalStorage("searchHistory", res.data)
			})
			.catch(() => props.setErrors(['Failed to fetch search history']))
	}, [])

	var userResults = props.users
		.filter((user) => {
			return user.username != props.auth.username &&
				user.username != "@blackmusic" &&
				user.account_type == "musician" &&
				user.username.match(props.search)
		})

	var videoResults = props.videos
		.filter((video) => video.name.match(props.search) &&
			video.username != props.auth.username)

	var audioResults = props.audios
		.filter((audio) => audio.name.match(props.search) &&
			audio.username != props.auth.username)

	var audioAlbumResults = props.audioAlbums
		.filter((audioAlbum) => {
			return audioAlbum.name != "Singles" &&
				audioAlbum.name.match(props.search) &&
				audioAlbum.username != props.auth.username
		})

	var videoAlbumResults = props.videoAlbums
		.filter((videoAlbum) => {
			return videoAlbum.name != "Singles" &&
				videoAlbum.name.match(props.search) &&
				videoAlbum.username != props.auth.username
		})

	// Save search
	const onSearch = (keyword) => {
		axios.get('/sanctum/csrf-cookie').then(() => {
			axios.post(`/api/search`, { keyword: keyword })
				.then((res) => props.setMessages([res.data]))
		})
	}

	// Delete search item
	const onDeleteSearch = (id) => {
		axios.delete(`api/search/${id}`)
			.then((res) => {
				// Update search
				axios.get(`/api/search`)
					.then((res) => setSearchHistory(res.data))
			})
	}

	return (
		<>
			<div className="row">
				<div className="col-sm-2"></div>
				<div className="col-sm-8">
					{/* <!-- For mobile --> */}
					{/* <!-- ***** Header Area Start ***** --> */}
					<header style={{ backgroundColor: "#232323" }} className="header-area anti-hidden">
						<div className="container-fluid p-0">
							<div className="row">
								<div className="col-12 p-0">
									{/* <!-- Contact form --> */}
									<div className="contact-form">
										<input
											ref={props.searchInput}
											className="form-control"
											placeholder="Search songs and artists"
											style={{ color: "white", width: "100%" }}
											onChange={(e) => {
												var regex = new RegExp(e.target.value, 'gi');
												props.setSearch(regex)
											}} />
									</div>
								</div>
							</div>
						</div>
					</header>
					<br className="anti-hidden" />

					{userResults.length == 0 &&
						videoResults.length == 0 &&
						audioResults.length == 0 &&
						videoAlbumResults.length == 0 &&
						audioAlbumResults.length == 0 &&
						searchHistory.map((search, key) => (
							<div key={key} className="d-flex justify-content-between border-bottom border-dark">
								<div className="p-2">
									<span>{search.keyword}</span>
								</div>
								<div className="p-2">
									<span style={{ cursor: "pointer" }} onClick={() => onDeleteSearch(search.id)}>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											width="30"
											height="30"
											fill="currentColor"
											className="bi bi-x"
											viewBox="0 0 16 16">
											<path
												d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
										</svg>
									</span>
								</div>
							</div>
						))}

					{/* <!-- ****** Artists Area Start ****** --> */}
					{userResults.length > 0 && <h4>Artists</h4>}
					<div className="hidden-scroll">
						{/*  Echo Artists  */}
						{userResults.map((artist, key) => (
							<AvatarMedia key={key} user={artist} />
						))}
						{/* Echo Artists End */}
					</div>
					{/* <!-- ****** Artists Area End ****** - */}
				</div>
				<div className="col-sm-2"></div>
			</div>

			<div className="row">
				<div className="col-sm-2"></div>
				<div className="col-sm-4">
					{/* Videos */}
					{videoResults.length > 0 &&
						<div className="mb-4 p-2 border-bottom">
							<h4>Videos</h4>
						</div>}
					{videoResults
						.slice(0, 5)
						.map((video, key) => (
							<div key={key} onClick={() => onSearch(video.name)}>
								<VideoMedia
									{...props}
									video={video}
									onClick={() => props.setShow(0)} />
							</div>
						))}
					{/* Videos End */}
				</div>

				<div className="col-sm-4">
					{/* Audios */}
					{audioResults.length > 0 &&
						<div className="p-2 mb-2 border-bottom">
							<h4>Audios</h4>
						</div>}
					{audioResults
						.slice(0, 5)
						.map((audio, key) => (
							<div key={key} onClick={() => onSearch(audio.name)}>
								<AudioMedia
									{...props}
									audio={audio} />
							</div>
						))}
					{/* Audios End */}
				</div>
				<div className="col-sm-3"></div>
			</div>

			<div className="row">
				<div className="col-sm-2"></div>
				<div className="col-sm-4">
					{videoAlbumResults.length > 0 &&
						<div className="p-2 mt-5 mb-3 border-bottom">
							<h4>Video Albums</h4>
						</div>}
					{/* Video Albums */}
					{videoAlbumResults.map((videoAlbum, key) => (
						<div key={key} className="d-flex" onClick={() => onSearch(videoAlbum.name)}>
							<div className="p-2">
								{videoAlbum.name != "Singles" ?
									<Img
										src={videoAlbum.cover}
										width="10em"
										height="10em"
										alt="album cover" /> : ""}
							</div>
							<div className="p-2">
								<small className="my-0">Video Album</small>
								<h1 className="my-0">{videoAlbum.name}</h1>
								<h6>{videoAlbum.createdAt}</h6>
							</div>
						</div>
					))}
					{/* Videos Albums End */}
				</div>
				<div className="col-sm-3">
					{audioAlbumResults.length > 0 &&
						<div className="p-2 mt-5 mb-3 border-bottom">
							<h4>Audio Albums</h4>
						</div>}
					{/* Audio Albums */}
					{audioAlbumResults.map((audioAlbum, key) => (
						<div key={key} className="d-flex" onSearch={() => onSearch(audioAlbum.name)}>
							<div className="p-2">
								{audioAlbum.name != "Singles" ?
									<Img src={audioAlbum.cover}
										width="10em"
										height="10em"
										alt="album cover" /> : ""}
							</div>
							<div className="p-2">
								<small>Audio Album</small>
								<h1 className="my-0">{audioAlbum.name}</h1>
								<h6>{audioAlbum.createdAt}</h6>
							</div>
						</div>
					))}
					{/* Audio Albums End */}
				</div>
				<div className="col-sm-2"></div>
			</div>
		</>
	)
}

export default Search
