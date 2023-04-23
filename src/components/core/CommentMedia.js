import Link from 'next/link'

import Img from '@/components/Core/Img'

import DecoSVG from '@/svgs/DecoSVG'
import OptionsSVG from '@/svgs/OptionsSVG'
import HeartSVG from '@/svgs/HeartSVG'
import HeartFilledSVG from '@/svgs/HeartFilledSVG'
import { useState } from 'react'

const CommentMedia = (props) => {

	const [hasLiked, setHasLiked] = useState(props.comment.hasLiked);

	return (
		<div className="d-flex">
			<div className="ps-1">
				<div className="avatar-thumbnail-xs" style={{ borderRadius: "50%" }}>
					<Link href={`/profile/${props.comment.username}`}>
						<a>
							<Img
								src={props.comment.avatar}
								imgClass="rounded-circle"
								width="3em"
								height="3em" />
						</a>
					</Link>
				</div>
			</div>
			<div className="p-1 flex-grow-1" style={{ textAlign: "left" }}>
				<h6 className="media-heading m-0"
					style={{
						width: "100%",
						whiteSpace: "nowrap",
						overflow: "hidden",
						textOverflow: "clip"
					}}>
					<b>{props.comment.name}</b>
					<small>{props.comment.username}</small>
					<span className="ms-1" style={{ color: "gold" }}>
						<DecoSVG />
						<small
							className="ms-1"
							style={{ color: "inherit" }}>{
								props.comment.decos}
						</small>
					</span>
					<small>
						<b><i className="float-end text-secondary me-1">{props.comment.createdAt}</i></b>
					</small>
				</h6>
				<p className="mb-0 text-white">{props.comment.text}</p>

				{/* Comment likes */}
				<a
					href="#"
					onClick={(e) => {
						e.preventDefault()
						props.onCommentLike(props.comment.id)
						setHasLiked(!hasLiked)
					}}>
					{hasLiked ?
						<span style={{ color: "#fb3958" }}>
							<HeartFilledSVG />
							<small
								className="ms-1"
								style={{ color: "inherit" }}>
								{props.comment.likes}
							</small>
						</span> :
						<span style={{ color: "rgba(220, 220, 220, 1)" }}>
							<HeartSVG />
							<small
								className="ms-1"
								style={{ color: "inherit" }}>
								{props.comment.likes}
							</small>
						</span>}
				</a>
				<small className="ms-1">{props.comment.comments}</small>

				{/* <!-- Default dropup button --> */}
				<div className="dropup-center dropup hidden float-end">
					<a
						href="#"
						className="text-white"
						role="button"
						data-bs-toggle="dropdown"
						aria-expanded="false">
						<OptionsSVG />
					</a>
					<div className="dropdown-menu dropdown-menu-right"
						style={{ borderRadius: "0", backgroundColor: "#232323" }}>
						{props.comment.username == props.auth.username &&
							<a
								href="#"
								className="dropdown-item"
								onClick={(e) => {
									e.preventDefault();
									props.onDeleteComment(props.comment.id)
								}}>
								<h6>Delete comment</h6>
							</a>}
					</div>
				</div>
				{/* For small screens */}
				<div className="float-end anti-hidden">
					<span
						className="text-secondary"
						onClick={() => {
							if (props.comment.username == props.auth.username) {
								props.setBottomMenu("menu-open")
								// Set Comment to edit so as to delete it as well
								props.setCommentToEdit(props.comment.id)
								// Show and Hide elements
								props.setCommentDeleteLink(true)
							}
						}}>
						<OptionsSVG />
					</span>
				</div>
			</div>
		</div>
	)
}

export default CommentMedia