import React, { useState, useEffect, Suspense } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'
import axios from '@/lib/axios'

import PostOptions from '@/components/Post/PostOptions'
import LoadingPostMedia from '@/components/Post/LoadingPostMedia'

const PostMedia = React.lazy(() => import('@/components/Post/PostMedia'))
const CommentMedia = React.lazy(() => import('@/components/core/CommentMedia'))


const PostShow = (props) => {

	const router = useRouter()

	// Get id from URL
	const { id } = router.query

	// Set states
	setTimeout(() => {
		props.setId(id)
		props.setPlaceholder("Add comment")
		props.setShowImage(false)
		props.setShowPoll(false)
		props.setShowImagePicker(false)
		props.setShowPollPicker(false)
		props.setUrlTo("post-comments")
		props.setUrlToTwo("posts")
		props.setStateToUpdate(() => props.setPostComments)
		props.setStateToUpdateTwo(() => props.setPosts)
		props.setEditing(false)
	}, 100)

	const [bottomMenu, setBottomMenu] = useState("")
	const [userToUnfollow, setUserToUnfollow] = useState()
	const [postToEdit, setPostToEdit] = useState()
	const [editLink, setEditLink] = useState()
	const [deleteLink, setDeleteLink] = useState()
	const [commentToEdit, setCommentToEdit] = useState()
	const [commentDeleteLink, setCommentDeleteLink] = useState()
	const [unfollowLink, setUnfollowLink] = useState()

	useEffect(() => {
		// Fetch Post Comments
		props.get("post-comments", props.setPostComments)
	}, [])

	// Function for deleting posts
	const onDeletePost = (id) => {
		axios.delete(`/api/posts/${id}`).then((res) => {
			props.setMessages([res.data])
			// Update posts
			props.get("posts", props.setPosts, "posts")
		}).catch((err) => props.getErrors(err))
	}

	// Function for liking comments
	const onCommentLike = (id) => {
		// Show like
		const newPostComments = props.postComments
			.filter((item) => {
				// Get the exact comment and change like status
				if (item.id == id) {
					item.hasLiked = !item.hasLiked
				}
				return true
			})
			
		// Set new comments
		props.setPostComments(newPostComments)

		// Add like to database
		axios.post(`/api/post-comment-likes`, {
			comment: id
		}).then((res) => {
			props.setMessages([res.data])
			// Update Post Comments
			props.get("post-comments", props.setPostComments)
		}).catch((err) => props.getErrors(err))
	}

	// Function for deleting comments
	const onDeleteComment = (id) => {
		axios.delete(`/api/post-comments/${id}`)
			.then((res) => {
				props.setMessages([res.data])
				// Update Post Comments
				props.get("post-comments", props.setPostComments)
				// Update Posts
				props.get("posts", props.setPosts, "posts")
			}).catch((err) => props.getErrors(err))
	}

	var dummyArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

	return (
		<>
			<div className="row">
				<div className="col-sm-4"></div>
				<div className="col-sm-4">
					<div className="my-2 ml-2">
						<Link href="/">
							<a>
								<svg
									width="2em"
									height="2em"
									viewBox="0 0 16 16"
									className="bi bi-arrow-left-short"
									fill="currentColor"
									xmlns="http://www.w3.org/2000/svg">
									<path fillRule="evenodd"
										d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z" />
									<path fillRule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z" />
								</svg>
							</a>
						</Link>
					</div>
					{props.posts
						.filter((post) => post.id == id)
						.map((post, key) => (
							<Suspense key={key} fallback={<LoadingPostMedia />}>
								<PostMedia
									{...props}
									post={post}
									setBottomMenu={setBottomMenu}
									setUserToUnfollow={setUserToUnfollow}
									setPostToEdit={setPostToEdit}
									setEditLink={setEditLink}
									setDeleteLink={setDeleteLink}
									setUnfollowLink={setUnfollowLink} />
							</Suspense>
						))}

					<hr className="text-white" />

					<div className="m-0 p-0">
						{/* Loading Comment items */}
						{dummyArray
							.filter(() => props.postComments.length < 1)
							.map((item, key) => (<LoadingPostMedia key={key} />))}

						{props.postComments
							.filter((comment) => comment.post_id == id)
							.map((comment, key) => (
								<Suspense key={key} fallback={<LoadingPostMedia />}>
									<CommentMedia
										{...props}
										comment={comment}
										setBottomMenu={setBottomMenu}
										setCommentDeleteLink={setCommentDeleteLink}
										setCommentToEdit={setCommentToEdit}
										onCommentLike={onCommentLike}
										onDeleteComment={onDeleteComment} />
								</Suspense>
							))}
					</div>
				</div>
				<div className="col-sm-4"></div>
			</div>

			{/* Sliding Bottom Nav */}
			<PostOptions
				{...props}
				bottomMenu={bottomMenu}
				setBottomMenu={setBottomMenu}
				unfollowLink={unfollowLink}
				userToUnfollow={userToUnfollow}
				editLink={editLink}
				postToEdit={postToEdit}
				deleteLink={deleteLink}
				onDeletePost={onDeletePost}
				commentToEdit={commentToEdit}
				commentDeleteLink={commentDeleteLink}
				onDeleteComment={onDeleteComment} />
			{/* Sliding Bottom Nav end */}
		</>
	)
}

export default PostShow
