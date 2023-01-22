import { useState, useEffect, Suspense } from 'react'
import axios from '@/lib/axios'

import CommentMedia from '@/components/core/CommentMedia'

import CloseSVG from '@/svgs/CloseSVG'
import PostOptions from '@/components/Post/PostOptions'
import SocialMediaInput from '../core/SocialMediaInput'

const KaraokeCommentSection = (props) => {

	const [bottomMenu, setBottomMenu] = useState()
	const [commentToEdit, setCommentToEdit] = useState()
	const [commentDeleteLink, setCommentDeleteLink] = useState()

	useEffect(() => {
		// Set states
		setTimeout(() => {
			props.setPlaceholder("Add a comment")
			props.setText("")
			props.setShowImage(false)
			props.setShowPoll(false)
			props.setShowEmojiPicker(false)
			props.setShowImagePicker(false)
			props.setShowPollPicker(false)
			// props.setUrlTo("karaoke-comments")
			// props.setStateToUpdate(() => props.setKaraokeComments)
			props.setEditing(false)
		}, 1000)

	}, [])

	// Declare new FormData object for form data
	const formData = new FormData();

	// Handle form submit for Social Input
	const onSubmit = (e) => {
		e.preventDefault()

		// Add form data to FormData object
		formData.append("text", props.text);
		formData.append("id", props.karaoke.id);

		// Get csrf cookie from Laravel inorder to send a POST request
		axios.post(`/api/karaoke-comments`, formData)
			.then((res) => {
				props.setMessages([res.data])
				// Updated Karaoke Comments One
				props.get("karaoke-comments", props.setKaraokeComments)
				// Clear text unless editing
				props.setText("")
				props.setShowMentionPicker(false)
				props.setShowEmojiPicker(false)
				props.setShowImagePicker(false)
				props.setShowPollPicker(false)
			}).catch((err) => props.getErrors(err))
	}

	// Function for liking comments
	const onCommentLike = (comment) => {
		// Show like
		const newKaraokeComments = props.karaokeComments
			.filter((item) => {
				// Get the exact karaoke and change like status
				if (item.id == comment) {
					item.hasLiked = !item.hasLiked
				}
				return true
			})
		// Set new karaokes
		props.setKaraokeComments(newKaraokeComments)

		// Add like to database
		axios.post(`/api/karaoke-comment-likes`, {
			comment: comment
		}).then((res) => {
			props.setMessages([res.data])
			// Update karaoke comments
			props.get("karaoke-comments", props.setKaraokeComments)
		}).catch((err) => props.getErrors(err))
	}

	// Function for deleting comments
	const onDeleteComment = (id) => {
		axios.delete(`/api/karaoke-comments/${id}`)
			.then((res) => {
				props.setMessages([res.data])
				// Update karaoke comments
				props.get("karaoke-comments", props.setKaraokeComments)
			}).catch((err) => props.getErrors(err))
	}

	return (
		<>
			{/* Sliding Bottom Nav */}
			<div className={props.bottomOptionsMenu}>
				<div className="commentMenu">
					<div
						className="d-flex align-items-center justify-content-between border-bottom border-dark"
						style={{ height: "3em" }}>
						<div className="dropdown-header p-2 text-white">
							<h5>Comments</h5>
						</div>
						{/* <!-- Close Icon --> */}
						<div
							className="closeIcon p-2 float-end"
							style={{ fontSize: "1em" }}
							onClick={() => props.setBottomOptionsMenu("")}>
							<CloseSVG />
						</div>
					</div>

					{/* Comment Form */}
					<form
						onSubmit={onSubmit}
						className="contact-form bg-white mb-2 border-bottom border-light"
						autoComplete="off">
						<Suspense
							fallback={
								<center>
									<div id="sonar-load" className="mt-5 mb-5"></div>
								</center>
							}>
							<SocialMediaInput {...props} />
						</Suspense>
					</form>

					{/* Karaoke Comments */}
					<div className="m-0 p-0">
						<div style={{ maxHeight: "60vh", overflowY: "scroll" }}>
							{/* Get Notifications */}

							{/* <!-- Comment Section --> */}
							{props.karaokeComments
								.filter((comment) => comment.karaoke_id == props.karaoke.id)
								.length > 0 ?
								props.karaokeComments
									.filter((comment) => comment.karaoke_id == props.karaoke.id)
									.map((comment, key) => (
										<CommentMedia
											{...props}
											key={key}
											comment={comment}
											onCommentLike={onCommentLike}
											setBottomMenu={setBottomMenu}
											setCommentToEdit={setCommentToEdit}
											onDeleteComment={onDeleteComment}
											setCommentDeleteLink={setCommentDeleteLink} />
									)) :
								<center className="my-3">
									<h6 style={{ color: "grey" }}>No comments to show</h6>
								</center>}
						</div>
						{/* Karaoke Comments End */}
					</div>
				</div>
			</div>
			{/* Sliding Bottom Nav End */}

			{/* Sliding Bottom Nav */}
			<PostOptions
				{...props}
				bottomMenu={bottomMenu}
				setBottomMenu={setBottomMenu}
				commentToEdit={commentToEdit}
				commentDeleteLink={commentDeleteLink}
				onDeleteComment={onDeleteComment} />
			{/* Sliding Bottom Nav end */}
		</>
	)
}

export default KaraokeCommentSection