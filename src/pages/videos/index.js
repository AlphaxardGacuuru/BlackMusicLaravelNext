import { useState, useEffect } from 'react'
import Link from 'next/link'
import axios from '@/lib/axios'

import Img from '@/components/core/Img'
import Btn from '@/components/core/Btn'

const Index = (props) => {

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
		axios.get('sanctum/csrf-cookie').then(() => {
			axios.post(`/api/users/${props.auth?.id}`, {
				account_type: "musician",
				_method: "put"
			}).then((res) => {
				props.setMessages(["You're now a Musician"])
				// Update Auth
				axios.get('api/auth')
					.then((res) => props.setAuth(res.data))
				// Update Users
				axios.get(`/api/users`)
					.then((res) => props.setUsers(res.data))
				// Update Video Albums
				axios.get(`/api/video-albums`)
					.then((res) => props.setVideoAlbums(res.data))
				// Update Audio Albums
				axios.get(`/api/audio-albums`)
					.then((res) => props.setAudioAlbums(res.data))
				// Remove loader
				setLoading(false)
			}).catch((err) => {
				const resErrors = err.response.data.errors
				var resError
				var newError = []
				for (resError in resErrors) {
					newError.push(resErrors[resError])
				}
				props.setErrors(newError)
			})
		})
	}

	return (
		<div className="sonar-call-to-action-area section-padding-0-100">

			{/* Become musician button */}
			<center className="mt-5 pt-5" style={{ display: button }}>
				<Btn
					btnText="become a musician"
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
						<Link href="/audios"><a className="btn sonar-btn btn-2">go to audios</a></Link>
						<br />
						<br />
						<Link href="/videos/create"><a className="btn sonar-btn">upload video</a></Link>
						<br />
						<br />
						<Link href="/videos/album-create"><a className="btn sonar-btn">create video album</a></Link>
					</center>
				</div>
			</div>
			<br />
			<div className="row" style={{ display: main }}>
				<div className="col-sm-2">
					<h1>Stats</h1>
					<table className='table'>
						<tbody className="border border-0">
							<tr className="border-top border-dark">
								<th className="border-top border-dark"><h5>Videos</h5></th>
								<th className="border-top border-dark">
									<h5>{props.videos
										.filter((video) => video.username == props.auth?.username)
										.length}</h5>
								</th>
							</tr>
						</tbody>
						<tbody className="border border-0">
							<tr className="border-top border-dark">
								<th className="border-top border-dark"><h5>Video Albums</h5></th>
								<th className="border-top border-dark">
									<h5>
										{props.videoAlbums
											.filter((videoAlbum) => videoAlbum.username == props.auth?.username)
											.length - 1}
									</h5>
								</th>
							</tr>
						</tbody>
						<tbody className="border border-0">
							<tr className="border-top border-dark">
								<td className="border-top border-dark"><h5>Downloads</h5></td>
								<td className="border-top border-dark">
									<h5>
										{props.boughtVideos
											.filter((boughtVideo) => boughtVideo.artist == props.auth?.username)
											.length}
									</h5>
								</td>
							</tr>
						</tbody>
						<tbody className="border border-0">
							<tr className="border-top border-dark">
								<td className="border-top border-dark"><h5>Revenue</h5></td>
								<td className="border-top border-dark">
									<h5 className="text-success">
										KES
										<span className="me-1 text-success">
											{props.boughtVideos
												.filter((boughtVideo) => boughtVideo.artist == props.auth?.username)
												.length * 10}
										</span>
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
											<Link href={`/video-album-edit/${videoAlbum.id}`}>
												<a>
													<Img
														src={`${videoAlbum.cover}`}
														width="100"
														height="100"
														alt="album cover" />
												</a>
											</Link> :
											<Img
												src={`${videoAlbum.cover}`}
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
								<table className="table table-responsive table-hover">
									<tbody className="border border-0">
										<tr className="border-top border-dark">
											<th className="border-top border-dark"><h5>Thumbnail</h5></th>
											<th className="border-top border-dark"><h5>Video Name</h5></th>
											<th className="border-top border-dark"><h5>ft</h5></th>
											<th className="border-top border-dark"><h5>Genre</h5></th>
											<th className="border-top border-dark"><h5>Description</h5></th>
											<th className="border-top border-dark"><h5>Downloads</h5></th>
											<th className="border-top border-dark"><h5 className="text-success">Revenue</h5></th>
											<th className="border-top border-dark"><h5>Likes</h5></th>
											<th className="border-top border-dark"><h5>Released</h5></th>
											<th className="border-top border-dark"><h5>Uploaded</h5></th>
											<th className="border-top border-dark"><h5></h5></th>
										</tr>
									</tbody>
									{props.videos
										.filter((video) => video.video_album_id == videoAlbum.id)
										.map((albumItem, key) => (
											<tbody key={key} className="border border-0">
												<tr className="border-top border-dark">
													<td className="border-top border-dark">
														<Link href={`/video-show/${albumItem.id}`}>
															<Img
																src={albumItem.thumbnail}
																width="160em"
																height="90em"
																alt={"thumbnail"} />
														</Link>
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.name}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.ft}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.genre}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.description}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.downloads}
													</td>
													<td className="border-top border-dark text-success">
														KES <span className="text-success">{albumItem.downloads * 10}</span>
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.likes}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{videoAlbum.released}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														{albumItem.created_at}
													</td>
													<td className="border-top border-dark" style={{ color: "rgba(220, 220, 220, 1) " }}>
														<Link href={`/video-edit/${albumItem.id}`}>
															<button className='mysonar-btn white-btn'>edit</button>
														</Link>
													</td>
												</tr>
											</tbody>
										))}
								</table>
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

export default Index