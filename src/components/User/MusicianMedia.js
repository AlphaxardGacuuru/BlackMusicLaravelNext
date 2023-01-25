import Link from 'next/link'
import axios from '@/lib/axios'
import Img from '@/components/core/Img'

import Btn from '../core/Btn'

import CheckSVG from '../../svgs/CheckSVG'

const MusiciansMedia = (props) => {

	const onFollow = (props) => {
		// Function for following users
		// Change follow button
		const newUsers = props.users
			.filter((item) => {
				// Get the exact user and change follow button
				if (item.username == props.user.username) {
					item.hasFollowed = !item.hasFollowed
				}
				return true
			})
		// Set new Users
		props.setUsers(newUsers)

		// Add follow
		axios.post(`/api/follows`, { musician: props.user.username })
			.then((res) => {
				props.setMessages([res.data])
				// Update users
				props.get("users", props.setUsers, "users")
				// Update posts
				props.get("posts", props.setPosts, "posts")
			}).catch((err) => props.getErrors(err, true))
	}

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
							loading="lazy" />
					</a>
				</Link>
			</div>
			<div className="p-2" style={{ width: "50%" }}>
				<Link href={`/profile/${props.user.username}`}>
					<a>
						<div style={{
							// width: "50%",
							// whiteSpace: "nowrap",
							overflow: "hidden",
							textOverflow: "clip"
						}}>
							<b className="ml-2">{props.user.name}</b>
							<small><i>{props.user.username}</i></small>
						</div>
					</a>
				</Link>
			</div>
			<div className="p-2 text-end flex-grow-1">
				{/* Check whether user has bought at least one song from user */}
				{/* Check whether user has followed user and display appropriate button */}
				{props.user.hasBought1 || props.auth?.username == "@blackmusic" ?
					props.user.hasFollowed ?
						<button
							className={'btn float-right rounded-0 text-light'}
							style={{ backgroundColor: "#232323" }}
							onClick={() => onFollow(props)}>
							Followed
							<CheckSVG />
						</button>
						: <Btn btnClass={'mysonar-btn white-btn float-right'}
							onClick={() => onFollow(props)}
							btnText={'follow'} />
					: <Btn btnClass={'mysonar-btn white-btn float-right'}
						onClick={() =>
							props.setErrors([`You must have bought atleast one song by ${props.user.username}`])}
						btnText={'follow'} />}
			</div>
		</div>
	)
}

export default MusiciansMedia