import Img from "next/image"
import Link from "next/link"

const StoryMedia = (props) => {
	return (
		<span
			className="mx-2 pt-0 px-0 pb-2 my-card"
			style={{
				display: "inline-block",
				// border: `2px solid ${props.story.seenAt ? "#232323" : "#FFD700"}`,
			}}>
			{/* <div style={{ border: "8px solid #000" }}> */}
				<div className="story-thumbnail">
					<Link href={`/story/${props.story.id}`} passHref>
						<a>
							<Img src={props.story.media} width="180em" height="320em" />
						</a>
					</Link>
				</div>
			{/* </div> */}
		</span>
	)
}

export default StoryMedia
