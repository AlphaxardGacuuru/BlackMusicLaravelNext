import Link from 'next/link'

import Img from '@/components/Core/Img'

const AvatarMedia = (props) => {
	return (
		<span className="m-0 p-0">
			<center>
				<div className="avatar-thumbnail" style={{ borderRadius: "50%" }}>
					<Link href={"/profile/" + props.user.username}>
						<a>
							<Img src={props.user.avatar}
								width='150px'
								height='150px' />
						</a>
					</Link>
				</div>
				<h6 className="mt-2 mb-0"
					style={{
						width: "100px",
						whiteSpace: "nowrap",
						overflow: "hidden",
						textOverflow: "clip"
					}}>
					{props.user.name}
				</h6>
				<h6 style={{
					width: "100px",
					whiteSpace: "nowrap",
					overflow: "hidden",
					textOverflow: "clip"
				}}>
					{props.user.username}
				</h6>
			</center>
		</span>
	)
}

export default AvatarMedia