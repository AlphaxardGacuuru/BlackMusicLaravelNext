import { useEffect } from 'react'
import Link from 'next/link'

// const SocialMediaInput = React.lazy(() => import('@/components/core/SocialMediaInput'))
import SocialMediaInput from '@/components/Core/SocialMediaInput'
import CloseSVG from '@/svgs/CloseSVG'

const PostCreate = (props) => {

	// Set states
	useEffect(() => {
		setTimeout(() => {
			props.setPlaceholder("What's on your mind")
			props.setText("")
			props.setShowImage(true)
			props.setShowPoll(true)
			props.setShowEmojiPicker(false)
			props.setShowImagePicker(false)
			props.setShowPollPicker(false)
			props.setUrlTo("posts")
			props.setStateToUpdate(() => props.setPosts)
			props.setEditing(false)
		}, 100)
	}, [])

	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				<div className="contact-form">
					<div className="d-flex justify-content-between mb-1">
						{/* <!-- Close Icon --> */}
						<div className="text-white">
							{props.media ?
								<span style={{ fontSize: "1.2em" }}>
									<CloseSVG />
								</span> :
								<Link href="/">
									<a style={{ fontSize: "1.2em" }}><CloseSVG /></a>
								</Link>}
						</div>
					</div>

					{/* Social Input */}
					<form
						onSubmit={props.onSubmit}
						className="contact-form bg-white"
						autoComplete="off">
						<SocialMediaInput {...props} />
					</form>
				</div>
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export default PostCreate
