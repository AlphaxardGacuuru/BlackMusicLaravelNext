import { useState, useEffect } from 'react'
import Link from 'next/link'
import axios from '@/lib/axios'

import Img from '@/components/core/Img'
import Btn from '@/components/core/Btn'

const Videos = (props) => {

	const [main, setMain] = useState("none")
	const [button, setButton] = useState("none")

	const [loading, setLoading] = useState()

	useEffect(() => {
		// Check if user is musician
		if (props.auth?.account_type == "musician") {
			setMain("")
			setButton("none")
		} else {
			setMain("none")
			setButton("")
		}
	}, [])


	// Become musician
	const onMusician = () => {
		// Show loader
		setLoading(true)

		// Set account type to musician
		axios.post(`/api/users/${props.auth?.id}`, {
			account_type: "musician",
			_method: "put"
		}).then((res) => {
			props.setMessages(["You're now a Musician"])
			// Update Auth
			props.get("auth", props.setAuth, "auth")
			// Update Video Albums
			props.get("video-albums", props.setVideoAlbums, "videoAlbums")
			// Update Audio Albums
			props.get("audio-albums", props.setAudioAlbums, "audioAlbums")
			// Update Users
			axios.get(`/api/users`)
				.then((res) => {
					setMain("")
					setButton("none")
					props.setUsers(res.data)
				})
		}).catch((err) => {
			setLoading(false)
			props.getErrors(err)
		})
	}

	// Get User's Audios
	const videos = props.videos.filter((video) => video.username == props.auth.username).length

	// Get User's Audio Albums
	const videoAlbums = props.videoAlbums
		.filter((videoAlbum) => videoAlbum.username == props.auth.username).length - 1

	// Get User's Audio Downloads
	const videoDownloads = props.boughtVideos
		.filter((boughtVideo) => boughtVideo.artist == props.auth.username).length

	// Get User's Audio Revenue
	const videoRevenue = props.boughtVideos
		.filter((boughtVideo) => boughtVideo.artist == props.auth.username)
		.length * 10

	return (
		<div className="sonar-call-to-action-area section-padding-0-100">

			{/* Become musician button */}
			<center className="mt-5 pt-5" style={{ display: button }}>
				<Btn
					btnText="become a musician"
					btnClass="sonar-btn btn-2"
					loading={loading}
					onClick={onMusician} />
			</center>
			{/* Become musician button End */}

			{/* <!-- ***** Call to Action Area Start ***** - */}
			<div className="backEnd-content">
				<h2 style={{ color: "rgba(255, 255, 255, 0.1)" }}>Studio</h2>
			</div>
			<div className="row" style={{ display: main }}>
				<div className="col-sm-12">
					<center>
						<h1 style={{ fontSize: "5em", fontWeight: "100" }}>Videos</h1>
						<br />
						<Link href="/audio"><a className="btn sonar-btn btn-2">go to audios</a></Link>
					</center>
				</div>
			</div>
			<div className="row" style={{ display: main }}>
				<div className="col-sm-4"></div>
				<div className="col-sm-2">
					<center>
						<Link href="/video/album/create">
							<a className="btn sonar-btn">create video album</a>
						</Link>
					</center>
				</div>
				<div className="col-sm-2">
					<center>
						<Link href="/video/create">
							<a className="btn sonar-btn">upload video</a>
						</Link>
					</center>
				</div>
				<div className="col-sm-4"></div>
			</div>
			<br />
			<div className="row" style={{ display: main }}>
				<div className="col-sm-2">
					<h1>Stats</h1>
					<table className='table'>
						<tbody>
							<tr>
								<th><h5>Videos</h5></th>
								<th><h5>{videos}</h5></th>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<th><h5>Video Albums</h5></th>
								<th><h5>{videoAlbums}</h5></th>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td><h5>Downloads</h5></td>
								<td><h5>{videoDownloads}</h5></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td><h5>Revenue</h5></td>
								<td>
									<h5 className="text-success">
										KES<span className="ms-1 text-success">{videoRevenue}</span>
									</h5>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div className="col-sm-9">
					{props.videoAlbums
						.filter((videoAlbum) => videoAlbum.username == props.auth?.username)
						.map((videoAlbum, key) => (
							<div key={key}>
								<div className="d-flex">
									<div className="p-2">
										{videoAlbum.name != "Singles" ?
											<Link href={`/video/album/${videoAlbum.id}`}>
												<a>
													<Img
														src={videoAlbum.cover}
														width="100"
														height="100"
														alt="album cover" />
												</a>
											</Link> :
											<Img
												src={videoAlbum.cover}
												width="100"
												height="100"
												alt="album cover" />}
									</div>
									<div className="p-2">
										<small>Video Album</small>
										<h1>{videoAlbum.name}</h1>
										<h6>{videoAlbum.created_at}</h6>
									</div>
								</div>
								<br />
								<div className="table-responsive">
									<table className="table table-borderless">
										<tbody className="table-group-divider">
											<tr>
												<th><h5>Thumbnail</h5></th>
												<th><h5>Video Name</h5></th>
												<th><h5>ft</h5></th>
												<th><h5>Genre</h5></th>
												<th><h5>Description</h5></th>
												<th><h5>Downloads</h5></th>
												<th><h5 className="text-success">Revenue</h5></th>
												<th><h5>Likes</h5></th>
												<th><h5>Released</h5></th>
												<th><h5>Uploaded</h5></th>
												<th><h5></h5></th>
											</tr>
										</tbody>
										{props.videos
											.filter((video) => video.video_album_id == videoAlbum.id)
											.map((albumItem, key) => (
												<tbody key={key}>
													<tr>
														<td>
															<Link href={`/video/edit/${albumItem.id}`}>
																<a>
																	<Img
																		src={albumItem.thumbnail}
																		width="160em"
																		height="90em"
																		alt="thumbnail" />
																</a>
															</Link>
														</td>
														<td>{albumItem.name}</td>
														<td>{albumItem.ft}</td>
														<td>{albumItem.genre}</td>
														<td>{albumItem.description}</td>
														<td>{albumItem.downloads}</td>
														<td className="text-success">
															KES <span className="text-success">{albumItem.downloads * 10}</span>
														</td>
														<td>{albumItem.likes}</td>
														<td>{videoAlbum.released}</td>
														<td>{albumItem.created_at}</td>
														<td>
															<Link href={`/video/edit/${albumItem.id}`}>
																<button className='mysonar-btn white-btn'>edit</button>
															</Link>
														</td>
													</tr>
												</tbody>
											))}
									</table>
								</div>
								<br />
								<br />
							</div>
						))}
				</div>
				<div className="col-sm-1"></div>
			</div>
		</div>
	)
}

export default Videos