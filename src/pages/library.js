import { useState, useEffect } from 'react'
import axios from '@/lib/axios'

import VideoMedia from '@/components/Video/VideoMedia'
import AudioMedia from '@/components/Audio/AudioMedia'
import KaraokeMedia from '@/components/Karaoke/KaraokeMedia'

const Library = (props) => {

	const [savedKaraokes, setSavedKaraokes] = useState([])
	const [tabClass, setTabClass] = useState("videos")

	useEffect(() => {
		// Fetch Saved Karaokes
		axios.get("/api/saved-karaokes")
			.then((res) => setSavedKaraokes(res.data))
			.catch(() => props.setErrors(["Failed to Fetch Saved Karaokes"]))
	}, [])

	return (
		<>
			<center><h1>Library</h1></center>

			{/* Tabs for Videos, Audios and Karaokes */}
			<div className="d-flex">
				<div className="p-2 flex-fill anti-hidden">
					<h4 className={tabClass == "videos" ? "active-scrollmenu" : "p-1"}
						onClick={() => setTabClass("videos")}>
						<center>Videos</center>
					</h4>
				</div>
				<div className="p-2 flex-fill anti-hidden">
					<h4 className={tabClass == "audios" ? "active-scrollmenu" : "p-1"}
						onClick={() => setTabClass("audios")}>
						<center>Audios</center>
					</h4>
				</div>
				<div className="p-2 flex-fill anti-hidden">
					<h4 className={tabClass == "karaokes" ? "active-scrollmenu" : "p-1"}
						onClick={() => setTabClass("karaokes")}>
						<center>Karaokes</center>
					</h4>
				</div>
			</div>
			{/* Tabs for Videos, Audios and Karaokes End */}

			<div className="row">
				<div className="col-sm-1"></div>
				{/* Video Area */}
				<div className={tabClass == "videos" ? "col-sm-3" : "col-sm-3 hidden"}>
					<center className="hidden"><h4>Videos</h4></center>
					{props.boughtVideos
						.filter((boughtVideo) => boughtVideo.username == props.auth.username)
						.length == 0 &&
						<center className="mt-3">
							<h6 style={{ color: "grey" }}>You haven't bought any videos</h6>
						</center>}

					{props.boughtVideos
						.filter((boughtVideo) => boughtVideo.username == props.auth.username)
						.map((boughtVideo, key) => (
							<VideoMedia
								{...props}
								video={boughtVideo}
								hasBoughtVideo="true" />
						))}
				</div>
				{/* Video Area End */}

				{/* Audio Area */}
				<div className={tabClass == "audios" ? "col-sm-4" : "col-sm-4 hidden"}>
					<center className="hidden"><h4>Audios</h4></center>
					{props.boughtAudios
						.filter((boughtAudio) => boughtAudio.username == props.auth.username)
						.length == 0 &&
						<center className="mt-3">
							<h6 style={{ color: "grey" }}>You haven't bought any audios</h6>
						</center>}

					{props.boughtAudios
						.filter((boughtAudio) => boughtAudio.username == props.auth.username)
						.map((boughtAudio, key) => (
							<AudioMedia
								{...props}
								key={key}
								audio={audio}
								hasBoughtAudio="true" />
						))}
				</div>
				{/* Audio Area End */}

				{/* Karaoke Area */}
				<div className={tabClass == "karaokes" ? "col-sm-3" : "col-sm-3 hidden"}>
					<center className="hidden"><h4>Karaokes</h4></center>
					<div className="d-flex justify-content-around flex-wrap">
						{savedKaraokes
							.length == 0 &&
							<center className="mt-3">
								<h6 style={{ color: "grey" }}>You haven't saved any karaokes</h6>
							</center>}

						{savedKaraokes
							.map((savedKaraoke, key) => (
								<KaraokeMedia
									{...props}
									key={key}
									setShow={props.setShow}
									karaoke={savedKaraoke} />
							))}
					</div>
				</div>
				{/* Karaoke Area End */}
				<div className="col-sm-1"></div>
			</div>
		</>
	)
}

export default Library