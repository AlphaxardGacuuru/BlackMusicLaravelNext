import Link from 'next/link'
import Img from 'next/image'
import Btn from '../core/Btn'

import CheckSVG from '../../svgs/CheckSVG'

const MusiciansMedia = (props) => {
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
			<div className="p-2 flex-grow-1">
				<Link href={`/profile/${props.user.username}`}>
					<a>
						<b className="ml-2">{props.user.name}</b>
						<small><i>{props.user.username}</i></small>
					</a>
				</Link>
			</div>
			<div className="p-2">

				{/* Check whether user has bought at least one song from user */}
				{/* Check whether user has followed user and display appropriate button */}
				{props.user.hasBought1 || props.auth?.username == "@blackmusic" ?
					props.user.hasFollowed ?
						<button
							className={'btn float-right rounded-0 text-light'}
							style={{ backgroundColor: "#232323" }}
							onClick={() => props.onFollow(props.user.username)}>
							Followed
							<CheckSVG />
						</button>
						: <Btn btnClass={'mysonar-btn white-btn float-right'}
							onClick={() => props.onFollow(props.user.username)}
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