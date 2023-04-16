import { useEffect } from "react"
import { useRouter } from "next/router"
import Link from "next/link"

import SocialMediaInput from "@/components/Core/SocialMediaInput"
import ssrAxios from "@/lib/ssrAxios"

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
									<svg
										xmlns="http://www.w3.org/2000/svg"
										width="40"
										height="40"
										fill="currentColor"
										className="bi bi-x"
										viewBox="0 0 16 16">
										<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
									</svg>
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
	await ssrAxios
		.get(`/api/posts/${id}`)
		.then((res) => (data.post = res.data))

	// Pass data to the page via props
	return { props: data }
}

export default PostEdit
