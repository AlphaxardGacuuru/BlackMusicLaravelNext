import Link from 'next/link'
import Img from '@/components/core/Img'

const Audios = (props) => {

	// Get User's Audios
	const audios = props.audios.filter((audio) => audio.username == props.auth.username).length

	// Get User's Audio Albums
	const audioAlbums = props.audioAlbums
		.filter((audioAlbum) => audioAlbum.username == props.auth.username).length - 1

	// Get User's Audio Downloads
	const audioDownloads = props.boughtAudios
		.filter((boughtAudio) => boughtAudio.artist == props.auth.username).length

	// Get User's Audio Revenue
	const audioRevenue = props.boughtAudios
		.filter((boughtAudio) => boughtAudio.artist == props.auth.username)
		.length * 5

	return (
		<div className="sonar-call-to-action-area section-padding-0-100">
			{/* <!-- ***** Call to Action Area Start ***** - */}
			<div className="backEnd-content">
				<h2 style={{ color: "rgba(255, 255, 255, 0.1)" }}>Studio</h2>
			</div>
			<div className="row">
				<div className="col-sm-12">
					<center>
						<h1 style={{ fontSize: "5em", fontWeight: "100" }}>Audios</h1>
						<br />
						<Link href="/video">
							<a className="btn sonar-btn btn-2">
								go to videos
							</a>
						</Link>
					</center>
				</div>
			</div>
			<div className="row">
				<div className="col-sm-4"></div>
				<div className="col-sm-2">
					<center>
						<Link href="/audio/album/create">
							<a className="btn sonar-btn">create audio album</a>
						</Link>
					</center>
				</div>
				<div className="col-sm-2">
					<center>
						<Link href="/audio/create">
							<a className="btn sonar-btn">upload audio</a>
						</Link>
					</center>
				</div>
				<div className="col-sm-4"></div>
			</div>
			<br />
			<div className="row">
				<div className="col-sm-2">
					<h1>Stats</h1>
					<table className='table'>
						<tbody>
							<tr>
								<th className="border-top-0"><h5>Audios</h5></th>
								<th className="border-top-0"><h5>{audios}</h5></th>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<th><h5>Audio Albums</h5></th>
								<th><h5>{audioAlbums}</h5></th>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td><h5>Downloads</h5></td>
								<td><h5>{audioDownloads}</h5></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td><h5>Revenue</h5></td>
								<td><h5 className="text-success">
									KES<span className="ms-1 text-success">{audioRevenue}</span>
								</h5>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div className="col-sm-9">
					{props.audioAlbums
						.filter((audioAlbum) => audioAlbum.username == props.auth.username)
						.map((audioAlbum, key) => (
							<div key={key}>
								<div className="d-flex">
									<div className="p-2">
										{audioAlbum.name != "Singles" ?
											<Link href={`/audio/album/edit/${audioAlbum.id}`}>
												<a>
													<Img src={audioAlbum.cover}
														width="10em"
														height="10em"
														alt="album cover" />
												</a>
											</Link> :
											<Img
												src={audioAlbum.cover}
												width="10em"
												height="10em"
												alt="album cover" />}
									</div>
									<div className="p-2">
										<small>Audio Album</small>
										<h1>{audioAlbum.name}</h1>
										<h6>{audioAlbum.created_at}</h6>
									</div>
								</div>
								<br />
								<div className="table-responsive">
									<table className="table table-borderless">
										<tbody className="table-group-divider">
											<tr>
												<th><h5>Thumbnail</h5></th>
												<th><h5>Audio Name</h5></th>
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
										{props.audios
											.filter((audio) => audio.audio_album_id == audioAlbum.id)
											.map((albumItem, key) => (
												<tbody key={key} className="table-group-divider">
													<tr>
														<td>
															<Link href={`/audio/edit/${albumItem.id}`}>
																<a onClick={() => {
																	props.setShow(albumItem.id)
																	props.setLocalStorage("show", {
																		"id": albumItem.id,
																		"time": 0
																	})
																}}>
																	<Img
																		src={albumItem.thumbnail}
																		width="50px"
																		height="50px"
																		alt="thumbnail" />
																</a>
															</Link>
														</td>
														<td>{albumItem.name}</td>
														<td>{albumItem.ft}</td>
														<td>{albumItem.genre}</td>
														<td>{albumItem.description}</td>
														<td>{albumItem.downloads}</td>
														<td className="text-success"
															style={{ color: "rgba(220, 220, 220, 1) " }}>
															KES <span className="text-success">{albumItem.downloads * 5}</span>
														</td>
														<td>{audioAlbum.likes}</td>
														<td>{audioAlbum.released}</td>
														<td>{audioAlbum.created_at}</td>
														<td>
															<Link href={`/audio/edit/${albumItem.id}`}>
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
		</div >
	)
}

export default Audios
