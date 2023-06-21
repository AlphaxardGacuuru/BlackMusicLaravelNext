import { useEffect, useState } from "react"
import Link from "next/link"

import SocialMediaInput from "@/components/Core/SocialMediaInput"
import CloseSVG from "@/svgs/CloseSVG"

// Import React FilePond
import { FilePond, registerPlugin } from "react-filepond"

// Import FilePond styles
import "filepond/dist/filepond.min.css"

// Import the Image EXIF Orientation and Image Preview plugins
// Note: These need to be installed separately
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImageCrop from "filepond-plugin-image-crop"
import FilePondPluginImageTransform from "filepond-plugin-image-transform"
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"

// Register the plugins
registerPlugin(
	FilePondPluginImageExifOrientation,
	FilePondPluginImagePreview,
	FilePondPluginFileValidateType,
	FilePondPluginImageCrop,
	FilePondPluginImageTransform,
	FilePondPluginFileValidateSize
)

const create = (props) => {
	const [revertUrl, setRevertUrl] = useState()

	// Set states
	useEffect(() => {
		setTimeout(() => {
			setRevertUrl(props.urlTo + "/")
			props.setPlaceholder("What's on your mind")
			props.setText("")
			// props.setMedia([])
			props.setShowImage(false)
			props.setShowPoll(false)
			props.setShowEmojiPicker(false)
			props.setShowImagePicker(false)
			props.setShowPollPicker(false)
			props.setUrlTo("stories")
			props.setStateToUpdate(() => props.setStories)
			props.setEditing(false)
		}, 100)
	}, [])

	useEffect(() => generateRevertUrl(), [props.media])

	const generateRevertUrl = () => {
		if (props.media.length > 0) {
			// Get media
			var media = props.media
			// Reverse array to always have to latest first
			media = media.reverse()
			// Parse string to JSON and get first element
			const parsed = JSON.parse(media[0])
			// const parsed = media[0]
			// Get name of key
			const key = Object.keys(parsed)
			// Get value by key
			setRevertUrl(parsed[key])
		}
	}
	console.log(revertUrl)
	console.log(props.media)

	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				<div className="contact-form">
					<div className="d-flex justify-content-between my-2">
						{/* <!-- Close Icon --> */}
						<div className="text-white">
							{props.media ? (
								<span style={{ fontSize: "1.2em" }}>
									<CloseSVG />
								</span>
							) : (
								<Link href="/">
									<a style={{ fontSize: "1.2em" }}>
										<CloseSVG />
									</a>
								</Link>
							)}
						</div>
						<h1>Create Story</h1>
						<a className="invisible">
							<CloseSVG />
						</a>
					</div>

					{/* Filepond */}
					<div className="">
						<center>
							<FilePond
								name="filepond-media"
								className="m-2 w-75"
								labelIdle='Drag & Drop your Image or <span class="filepond--label-action text-dark"> Browse </span>'
								acceptedFileTypes={["image/*"]}
								stylePanelAspectRatio="9:16"
								allowRevert={true}
								server={{
									url: `${props.url}/api/filepond/`,
									process: {
										url: props.urlTo,
										onload: (res) => props.setMedia([...props.media, res]),
									},
									revert: {
										url: revertUrl,
										onload: (res) => {
											props.setMessages([res])
											props.setMedia([props.media.shift()])
										},
									},
								}}
							/>
						</center>
						<br />
					</div>
					{/* Filepond End */}
				</div>
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export default create
