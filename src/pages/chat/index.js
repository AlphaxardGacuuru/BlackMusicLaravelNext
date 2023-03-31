import { useEffect } from "react"
import Link from "next/link"
import Img from "@/components/Core/Img"

import ChatSVG from "@/svgs/ChatSVG"
import ImageSVG from "@/svgs/ImageSVG"

const Chat = (props) => {

	// Fetch Help Threads
	useEffect(() => {
		props.get("chats", props.setChatThreads, "chatThreads")
	}, [])

	var raise = props.audioStates.show.id != 0 && props.audioStates.show.id != undefined

	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				{/* Chat button */}
				<Link href="/chat/new">
					<a id="chatFloatBtn" className={raise ? "mb-5" : undefined}>
						<ChatSVG />
					</a>
				</Link>

				{/* Default Thread */}
				{props.chatThreads.length == 0 && (
					<div className="d-flex">
						<div className="p-2">
							<Link href="/chat/@blackmusic">
								<a>
									<Img
										src={
											props.users.find(
												(user) => user.username == "@blackmusic"
											) &&
											props.users.find((user) => user.username == "@blackmusic")
												.avatar
										}
										imgClass="rounded-circle"
										width="50px"
										height="50px"
									/>
								</a>
							</Link>
						</div>
						<div className="p-2 flex-grow-1">
							<Link href="/chat/@blackmusic">
								<a>
									<h6
										className="m-0"
										style={{
											width: "100%",
											whiteSpace: "nowrap",
											overflow: "hidden",
											textOverflow: "clip",
										}}>
										<b>Black Music</b>
										<small>@blackmusic</small>
									</h6>
									<p className="mb-0">Need help? Start a conversation.</p>
								</a>
							</Link>
						</div>
					</div>
				)}
				{/* Start Thread End */}

				{/* Threads Start */}
				{props.chatThreads.map((chatThread, key) => (
					<div key={key} className="d-flex">
						<div className="pt-2">
							<Link href={`/chat/${chatThread.username}`}>
								<a>
									<Img
										src={chatThread.avatar}
										imgClass="rounded-circle"
										width="50px"
										height="50px"
									/>
								</a>
							</Link>
						</div>
						<div
							className="p-2 flex-grow-1"
							style={{
								maxWidth: "75%",
								wordWrap: "break-word",
							}}>
							<Link href={`/chat/${chatThread.username}`}>
								<a>
									<h6
										className="m-0"
										style={{
											width: "100%",
											whiteSpace: "nowrap",
											overflow: "hidden",
											textOverflow: "clip",
										}}>
										<b>{chatThread.name}</b>
										<small>{chatThread.username}</small>
									</h6>
									<p
										className="m-0"
										style={{
											width: "100%",
											whiteSpace: "nowrap",
											overflow: "hidden",
											textOverflow: "clip",
										}}>
										{chatThread.text}
										{chatThread.hasMedia && (
											<span className="ms-1" style={{ cursor: "pointer" }}>
												<ImageSVG />
											</span>
										)}
									</p>
								</a>
							</Link>
						</div>
						<div className="py-2">
							<small>
								<i className="float-end mr-1">{chatThread.created_at}</i>
							</small>
						</div>
					</div>
				))}
				{/* Threads End */}
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export default Chat
