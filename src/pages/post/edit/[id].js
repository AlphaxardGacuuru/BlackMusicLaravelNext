import { useEffect } from "react"
import { useRouter } from "next/router"
import Link from "next/link"

import SocialMediaInput from "@/components/Core/SocialMediaInput"
import ssrAxios from "@/lib/ssrAxios"
import CloseSVG from "@/svgs/CloseSVG"

const PostEdit = (props) => {
	const router = useRouter()

	let { id } = router.query

	useEffect(() => {
		// Set states
		setTimeout(() => {
			props.setText(props.post.text)
			props.setPlaceholder("What's on your mind")
			props.setShowImage(false)
			props.setShowPoll(false)
			props.setShowEmojiPicker(false)
			props.setShowImagePicker(false)
			props.setShowPollPicker(false)
			props.setUrlTo(`posts/${id}`)
			props.setUrlToTwo(`posts`)
			props.setStateToUpdate(() => props.setPosts)
			props.setStateToUpdateTwo(() => props.setPosts)
			props.setEditing(true)
		}, 100)
	}, [id])

	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				<div className="contact-form">
					<div className="d-flex justify-content-between mb-1">
						{/* <!-- Close Icon --> */}
						<div className="text-white">
							<Link href="/">
								<a>
									<CloseSVG />
								</a>
							</Link>
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

// This gets called on every request
export async function getServerSideProps(context) {
	const { id } = context.query

	var data = {
		post: {},
	}

	// Fetch Post Comments
	await ssrAxios.get(`/api/posts/${id}`).then((res) => (data.post = res.data))

	// Pass data to the page via props
	return { props: data }
}

export default PostEdit
