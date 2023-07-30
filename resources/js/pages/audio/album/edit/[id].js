import React, { useState, useEffect } from "react"
import { Link, useParams } from "react-router-dom"
// import Axios from "axios"

import Btn from "@/components/Core/Btn"
import Img from "@/components/Core/Img"
import ImageSVG from "@/svgs/ImageSVG"

const AudioAlbumEdit = (props) => {
	let { id } = useParams()

	// Declare states
	const [album, setAlbum] = useState({})
	const [formData, setFormData] = useState()
	const [name, setName] = useState("")
	const [released, setReleased] = useState("")
	const [preview, setPreview] = useState()
	const [cover, setCover] = useState("")
	const [btnLoading, setBtnLoading] = useState()

	// Assign id to element
	const mediaInput = React.useRef(null)

	useEffect(() => {
		// Declare new FormData object for form data
		setFormData(new FormData())

		props.get(`/audio-albums/${id}`, setAlbum)
	}, [])

	// Fire when image is choosen
	var onImageChange = (event) => {
		if (event.target.files && event.target.files[0]) {
			var img = event.target.files[0]
			setCover(img)
			setPreview(URL.createObjectURL(img))
		}
	}

	const onSubmit = (e) => {
		e.preventDefault()

		// Show loader for button
		setBtnLoading(true)

		// Add form data to FormData object
		formData.append("name", name)
		formData.append("released", released)
		cover && formData.append("cover", cover)
		formData.append("_method", "put")

		// Send data to PostsController
		// Get csrf cookie from Laravel inorder to send a POST request
		Axios.get("sanctum/csrf-cookie").then(() => {
			Axios.post(`/api/audio-albums/${id}`, formData)
				.then((res) => {
					props.setMessages([res.data.message])
					// Update Album
					props.get(`/audio-albums/${id}`, setAlbum)
					// Reset preview photo
					setPreview()
					// Remove loader for button
					setBtnLoading(false)
				})
				.catch((err) => {
					// Remove loader for button
					setBtnLoading(false)
					props.getErrors(err)
				})
		})
	}

	return (
		<div>
			{/* <!-- ***** Call to Action Area Start ***** --> */}
			<div className="sonar-call-to-action-area section-padding-0-100">
				<div className="backEnd-content">
					<h2 style={{ color: "rgba(255, 255, 255, 0.1)" }}>Studio</h2>
				</div>

				<div className="container">
					<div className="row">
						<div className="col-12">
							<div
								className="mycontact-form text-center call-to-action-content wow fadeInUp"
								data-wow-delay="0.5s">
								<h2>Edit Audio Album</h2>
								<div className="d-flex text-start">
									<div className="p-2">
										<Img
											src={album.cover}
											width="80em"
											height="80em"
											alt="album cover"
										/>
									</div>
									<div className="px-2">
										<h1 className="my-0">{album.name}</h1>
										<h6 className="my-0">{album.released}</h6>
									</div>
								</div>
								<br />
								<div className="form-group">
									<form onSubmit={onSubmit}>
										<input
											type="text"
											name="name"
											className="my-form"
											placeholder="Name"
											onChange={(e) => {
												setName(e.target.value)
											}}
										/>
										<br />
										<br />

										<label className="text-light">Released</label>
										<input
											type="date"
											name="released"
											className="my-form"
											placeholder="Released"
											onChange={(e) => {
												setReleased(e.target.value)
											}}
										/>
										<br />
										<br />

										<label className="text-light">Upload Album Cover</label>
										<div
											className="mb-2"
											style={{ overflow: "hidden" }}>
											<img
												src={preview}
												width="100%"
												height="auto"
											/>
										</div>

										{/* Hidden file input */}
										<input
											type="file"
											style={{ display: "none" }}
											ref={mediaInput}
											onChange={onImageChange}
										/>

										<div
											className="p-2"
											style={{
												backgroundColor: "#232323",
												color: "white",
												cursor: "pointer",
											}}
											onClick={() => mediaInput.current.click()}>
											<ImageSVG />
										</div>
										<br />
										<br />

										<Btn
											type="submit"
											btnText="edit album"
											loading={btnLoading}
										/>
										<br />
										<br />

										<Link
											to="/audio"
											className="btn sonar-btn btn-2">
											studio
										</Link>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	)
}

export default AudioAlbumEdit