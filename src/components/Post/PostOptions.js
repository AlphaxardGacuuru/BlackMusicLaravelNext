import Link from "next/link"

import CloseSVG from "@/svgs/CloseSVG"
import onFollow from "@/functions/onFollow"

const PostOptions = (props) => {
	const props2 = { ...props, user: { username: props.userToUnfollow } }
	return (
		<div className={props.bottomMenu}>
			<div className="bottomMenu">
				<div className="d-flex align-items-center justify-content-between border-bottom border-dark">
					<div></div>
					{/* <!-- Close Icon --> */}
					<div
						className="closeIcon float-end mr-3"
						style={{ fontSize: "0.8em" }}
						onClick={() => props.setBottomMenu("")}>
						<CloseSVG />
					</div>
				</div>

				{props.unfollowLink && (
					<div
						onClick={() => {
							props.setBottomMenu("")
							onFollow(props2)
						}}>
						<h6 className="pb-2">Unfollow {props.userToUnfollow}</h6>
					</div>
				)}
				{props.editLink && (
					<Link href={`/post/edit/${props.postToEdit}`}>
						<a onClick={() => props.setBottomMenu("")}>
							<h6 className="pb-2">Edit post</h6>
						</a>
					</Link>
				)}
				{props.deleteLink && (
					<div
						onClick={() => {
							props.setBottomMenu("")
							props.onDeletePost(props.postToEdit)
						}}>
						<h6 className="pb-2">Delete post</h6>
					</div>
				)}
				{props.commentDeleteLink && (
					<div
						onClick={() => {
							props.setBottomMenu("")
							props.onDeleteComment(props.commentToEdit)
						}}>
						<h6 className="pb-2">Delete comment</h6>
					</div>
				)}
			</div>
		</div>
	)
}

export default PostOptions
