import React from 'react'
import { useState, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'
import axios from '@/lib/axios';
import Btn from '@/components/core/Btn'

const VideoAlbumCreate = (props) => {

	// Declare states
	const [formData, setFormData] = useState()
	const [name, setName] = useState("")
	const [released, setReleased] = useState("")
	const [preview, setPreview] = useState()
	const [cover, setCover] = useState("")
	const [loadingBtn, setLoadingBtn] = useState()

	// Get history for page location
	const router = useRouter()

	// Assign id to element
	const mediaInput = React.useRef(null)

	useEffect(() => {
		// Declare new FormData object for form data
		setFormData(new FormData())
	}, [])

	// Fire when image is choosen
	var onImageChange = event => {
		if (event.target.files && event.target.files[0]) {
			var img = event.target.files[0];
			setCover(img)
			setPreview(URL.createObjectURL(img))
		}
	};

	const onSubmit = (e) => {
		e.preventDefault()

		// Show loader for button
		setLoadingBtn(true)

		// Add form data to FormData object
		formData.append("name", name);
		formData.append("released", released);
		cover && formData.append("cover", cover);

		// Send data to PostsController
		// Get csrf cookie from Laravel inorder to send a POST request
		axios.post(`${props.url}/api/video-albums`, formData)
			.then((res) => {
				props.setMessages([res.data])
				props.get("video-albums", props.setVideoAlbums, "videoAlbums")
				// Remove loader for button
				setLoadingBtn(false)
				setTimeout(() => router.push('/video'), 500)
			}).catch(err => {
				// Remove loader for button
				setLoadingBtn(false)
				props.getErrors(err)
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
							<div className="contact-form text-center call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
								<h2>Create Video Album</h2>
								<br />
								<div className="form-group">
									<form onSubmit={onSubmit}>

										<input
											type="text"
											name="name"
											className="form-control"
											placeholder="Name"
											required={true}
											onChange={(e) => { setName(e.target.value) }} />

										<br />
										<br />

										<label className="text-light">Released</label>
										<input
											type="date"
											name="released"
											className="form-control"
											placeholder="Released"
											required={true}
											onChange={(e) => { setReleased(e.target.value) }} />

										<br />
										<br />

										<label className="text-light">Upload Album Cover</label>
										<div
											className="mb-2"
											style={{ overflow: "hidden" }}>

											<img
												src={preview}
												width="100%"
												height="auto" />
										</div>

										{/* Hidden file input */}
										<input
											type='file'
											style={{ display: 'none' }}
											ref={mediaInput}
											onChange={onImageChange} />

										<div
											className="p-2"
											style={{ backgroundColor: "#232323", color: "white" }}
											onClick={() => mediaInput.current.click()}>
											<svg xmens="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
												className="bi bi-image" viewBox="0 0 16 16">
												<path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
												<path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
											</svg>
										</div>

										<br />
										<br />

										<Btn
											type="submit"
											btnText="create album"
											loading={loadingBtn} />

										<br />
										<br />

										<Link href="/video"><a className="btn sonar-btn btn-2">studio</a></Link>
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

export default VideoAlbumCreate
