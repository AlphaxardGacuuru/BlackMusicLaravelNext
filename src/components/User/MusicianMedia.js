import { useEffect, useState } from "react"
import Link from "next/link"
import Img from "@/components/Core/Img"
import Btn from "../Core/Btn"

import onFollow from "@/functions/onFollow"

import CheckSVG from "../../svgs/CheckSVG"

const MusiciansMedia = (props) => {
	const [hasFollowed, setHasFollowed] = useState(props.user.hasFollowed)

	useEffect(() => {
		// Set new cart with data with auth
		setHasFollowed(props.user.hasFollowed)
	}, [props.user])

	return (
		<div className="d-flex">
			<div className="p-2">
				<Link href={`/profile/${props.user.username}`}>
					<a>
						<Img
							src={props.user.avatar}
							className="rounded-circle"
							width="30px"
							height="30px"
							alt="user"
							loading="lazy"
						/>
					</a>
				</Link>
			</div>
			<div className="p-2" style={{ width: "50%" }}>
				<Link href={`/profile/${props.user.username}`}>
					<a>
						<div
							style={{
								// width: "50%",
								// whiteSpace: "nowrap",
								overflow: "hidden",
								textOverflow: "clip",
							}}>
							<b className="ml-2">{props.user.name}</b>
							<small>
								<i>{props.user.username}</i>
							</small>
						</div>
					</a>
				</Link>
			</div>
			<div className="p-2 text-end flex-grow-1">
				{/* Check whether user has bought at least one song from user */}
				{/* Check whether user has followed user and display appropriate button */}
				{props.user.hasBought1 || props.auth?.username == "@blackmusic" ? (
					hasFollowed ? (
						<button
							className={"btn float-right rounded-0 text-light"}
							style={{ backgroundColor: "#232323" }}
							onClick={() => {
								setHasFollowed(!hasFollowed)
								onFollow(props, props.user.username)
							}}>
							Followed
							<CheckSVG />
						</button>
					) : (
						<Btn
							btnClass={"mysonar-btn white-btn float-right"}
							onClick={() => {
								setHasFollowed(!hasFollowed)
								onFollow(props, props.user.username)
							}}
							btnText="follow"
						/>
					)
				) : (
					<Btn
						btnClass={"mysonar-btn white-btn float-right"}
						onClick={() =>
							props.setErrors([
								`You must have bought atleast one song by ${props.user.username}`,
							])
						}
						btnText="follow"
					/>
				)}
			</div>
		</div>
	)
}

export default MusiciansMedia
