import React, { useState, useEffect } from "react"
import Link from "next/link"
import { useRouter } from "next/router"
import axios from "@/lib/axios"
import ssrAxios from "@/lib/ssrAxios"
import EchoConfig from "@/lib/echo"

import CommentMedia from "@/components/Core/CommentMedia"
import PostMedia from "@/components/Post/PostMedia"
import PostOptions from "@/components/Post/PostOptions"
import LoadingPostMedia from "@/components/Post/LoadingPostMedia"
import BackSVG from "@/svgs/BackSVG"

const PostShow = (props) => {
	const router = useRouter()

	// Get id from URL
	const { id } = router.query

	const [post, setPost] = useState(props.post)
	const [postComments, setPostComments] = useState(props.comments)
	const [newPostComments, setNewPostComments] = useState()
	const [bottomMenu, setBottomMenu] = useState("")
	const [userToUnfollow, setUserToUnfollow] = useState()
	const [postToEdit, setPostToEdit] = useState()
	const [editLink, setEditLink] = useState()
	const [deleteLink, setDeleteLink] = useState()
	const [commentToEdit, setCommentToEdit] = useState()
	const [commentDeleteLink, setCommentDeleteLink] = useState()
	const [unfollowLink, setUnfollowLink] = useState()

	useEffect(() => {
		// Instantiate Echo
		EchoConfig()

		Echo.private(`post-comments`).listen("PostCommentedEvent", (e) => {
			setNewPostComments(e.comment)
		})

		// Fetch Post
		id && props.get(`posts/${id}`, setPost)
		// Fetch Post Comments
		id && props.get(`post-comments/${id}`, setPostComments)
	}, [id])

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
		props.setStateToUpdate(() => setPostComments)
		props.setStateToUpdateTwo(() => props.setPosts)
		props.setEditing(false)
	}, 100)

	/*
	 * Function for deleting posts */
	const onAddComments = () => {
		setPostComments([newPostComments, ...postComments])
		setNewPostComments()
	}

	/*
	 * Function for deleting posts */
	const onDeletePost = (id) => {
		axios
			.delete(`/api/posts/${id}`)
			.then((res) => {
				props.setMessages([res.data])
				// Update posts
				props.get("posts", props.setPosts, "posts")
			})
			.catch((err) => props.getErrors(err))
	}

	/*
	 * Function for liking comments */
	const onCommentLike = (id) => {
		// Show like
		const newPostComments = postComments.filter((item) => {
			// Get the exact comment and change like status
			if (item.id == id) {
				item.hasLiked = !item.hasLiked
			}
			return true
		})

		// Set new comments
		setPostComments(newPostComments)

		// Add like to database
		axios
			.post(`/api/post-comment-likes`, {
				comment: id,
			})
			.then((res) => {
				props.setMessages([res.data])
				// Update Post Comments
				props.get("post-comments", setPostComments)
			})
			.catch((err) => props.getErrors(err))
	}

	/*
	 * Function for deleting comments */
	const onDeleteComment = (id) => {
		axios
			.delete(`/api/post-comments/${id}`)
			.then((res) => {
				props.setMessages([res.data])
				// Update Post Comments
				props.get("post-comments", setPostComments)
				// Update Posts
				props.get("posts", props.setPosts, "posts")
			})
			.catch((err) => props.getErrors(err))
	}

	var dummyArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

	return (
		<>
			<div className="row">
				<center>
					<h6
						id="snackbar-up"
						style={{ cursor: "pointer" }}
						className={newPostComments && "show"}
						onClick={onAddComments}>
						<div>New Comments</div>
					</h6>
				</center>
				<div className="col-sm-4"></div>
				<div className="col-sm-4">
					<div className="d-flex my-2">
						<Link href="/">
							<a>
								<BackSVG />
							</a>
						</Link>
						<h1 className="mx-auto">Post</h1>
						<a className="invisible">
							<BackSVG />
						</a>
					</div>
					<span>
						<PostMedia
							{...props}
							post={post}
							setBottomMenu={setBottomMenu}
							setUserToUnfollow={setUserToUnfollow}
							setPostToEdit={setPostToEdit}
							setEditLink={setEditLink}
							setDeleteLink={setDeleteLink}
							setUnfollowLink={setUnfollowLink}
						/>
					</span>

					<hr className="text-white" />

					<div className="m-0 p-0">
						{/* Loading Comment items */}
						{dummyArray
							.filter(() => postComments.length < 1)
							.map((item, key) => (
								<LoadingPostMedia key={key} />
							))}

						{postComments.map((comment, key) => (
							<CommentMedia
								{...props}
								key={key}
								comment={comment}
								setBottomMenu={setBottomMenu}
								setCommentDeleteLink={setCommentDeleteLink}
								setCommentToEdit={setCommentToEdit}
								onCommentLike={onCommentLike}
								onDeleteComment={onDeleteComment}
							/>
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
				onDeleteComment={onDeleteComment}
			/>
			{/* Sliding Bottom Nav end */}
		</>
	)
}

// This gets called on every request
export async function getServerSideProps(context) {
	const { id } = context.query

	var data = { post: {}, comments: {} }

	// Fetch Post Comments
	await ssrAxios.get(`/api/posts/${id}`).then((res) => (data.post = res.data))
	await ssrAxios
		.get(`/api/post-comments/${id}`)
		.then((res) => (data.comments = res.data))

	// Pass data to the page via props
	return { props: data }
}

export default PostShow
