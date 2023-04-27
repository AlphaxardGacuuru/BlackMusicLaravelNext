import { useState, useEffect } from "react"
import Link from "next/link"
import { useRouter } from "next/router"

import Img from "@/components/Core/Img"
import axios from "@/lib/axios"
import TrashSVG from "@/svgs/TrashSVG"
import BackSVG from "@/svgs/BackSVG"
import EchoConfig from "@/lib/echo"

const ChatThread = (props) => {
	const router = useRouter()

	let { username } = router.query

	const [chats, setChats] = useState([])
	const [newChat, setNewChat] = useState({})
	const [toDeleteIds, setToDeleteIds] = useState([])
	const [deletedIds, setDeletedIds] = useState([])

	useEffect(() => {
		// Instantiate Echo
		EchoConfig()

		Echo.private(`chat-created`).listen("NewChatEvent", (e) => {
			console.log("received")
			setNewChat(e.chat)
		})

		// Fetch Chat
		props.get(`chats/${username}`, setChats)

		// Set states
		setTimeout(() => {
			props.setTo(username)
			props.setPlaceholder("Message")
			props.setText("")
			props.setShowImage(true)
			props.setShowPoll(false)
			props.setShowEmojiPicker(false)
			props.setShowImagePicker(false)
			props.setShowPollPicker(false)
			props.setUrlTo("chats")
			props.setUrlToTwo()
			props.setStateToUpdate()
			props.setStateToUpdateTwo()
			props.setEditing(false)
		}, 1000)
	}, [username])

	/*
	 * Show new chats */
	useEffect(() => {
		// Remove duplicate
		var cleanChats = chats.filter((chat) => chat.id != newChat.id)
		// Set new chats
		setChats([...cleanChats, newChat])
	}, [newChat])

	/*
	 * Show Delete */
	const showDelete = (id) => {
		if (toDeleteIds.includes(id)) {
			var newToDeleteIds = toDeleteIds.filter((toDeleteId) => toDeleteId != id)
			setToDeleteIds(newToDeleteIds)
		} else {
			setToDeleteIds([...toDeleteIds, id])
		}
	}

	/*
	 * Function for deleting chat */
	const onDeleteChat = (id) => {
		// Remove item
		setDeletedIds([...deletedIds, id])

		axios
			.delete(`/api/chats/${id}`)
			.then((res) => props.setMessages([res.data]))
			.catch((err) => props.getErrors(err))
	}

	// Ensure latest chat is always visible
	useEffect(() => {
		// Scroll to the bottom of the page
		window.scrollTo(0, document.body.scrollHeight)
	}, [chats])

	// // Long hold to show delete button
	// var chatDiv = useRef(null)

	// if (chatDiv.current) {
	// 	chatDiv.current
	// 		.addEventListener("mousedown", () => {
	// 			const timeout = setTimeout(() => setShowDelete(!showDelete), 1000)

	// 			chatDiv.current
	// 				.addEventListener("mouseup", () => clearTimeout(timeout))
	// 		})

	// 	// For mobile
	// 	chatDiv.current
	// 		.addEventListener("touchstart", () => {
	// 			const timeout = setTimeout(() => setShowDelete(!showDelete), 1000)

	// 			chatDiv.current
	// 				.addEventListener("touchend", () => clearTimeout(timeout))
	// 		})
	// }

	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				{/* <!-- ***** Header Area Start ***** --> */}
				<header style={{ backgroundColor: "#232323" }} className="header-area">
					<div className="container-fluid p-0">
						<div className="row">
							<div className="col-12" style={{ padding: "0" }}>
								<div className="menu-area d-flex justify-content-between">
									{/* <!-- Logo Area  --> */}
									<div className="logo-area">
										<Link href="/chat">
											<a className="fs-6">
												<BackSVG />
											</a>
										</Link>
									</div>

									{/* User info */}
									<div className="menu-content-area d-flex align-items-center">
										<div className="text-white">
											<center>
												<h6
													className="m-0"
													style={{
														width: "100%",
														whiteSpace: "nowrap",
														overflow: "hidden",
														textOverflow: "clip",
													}}>
													<b className="text-white">{chats[0]?.name}</b>
													<br />
													<small className="text-white">{username}</small>
												</h6>
											</center>
										</div>
									</div>

									<div className="menu-content-area d-flex align-items-center">
										<div>
											<Link href={`/profile/${username}`}>
												<a>
													<Img
														src={chats[0]?.avatar}
														imgClass="rounded-circle"
														width="40px"
														height="40px"
													/>
												</a>
											</Link>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
				{/* <!-- ***** Header Area End ***** --> */}
				<br />
				<br />
				<br />
				<br className="hidden" />

				{/* <!-- ***** Chats ***** --> */}
				<div className="sonar-call-to-action-area section-padding-0-100">
					<div className="backEnd-content">
						<h2 className="p-2" style={{ color: "rgba(255,255,255,0.1)" }}>
							Chat
						</h2>
					</div>
					{chats
						.filter((chat) => !deletedIds.includes(chat.id))
						.map((chatItem, key) => (
							<div
								key={key}
								className={`d-flex
								${
									chatItem.username == props.auth.username
										? "flex-row-reverse"
										: "text-light"
								}`}>
								{/* Trash */}
								{chatItem.username == props.auth.username &&
									toDeleteIds.includes(chatItem.id) && (
										<div
											style={{
												cursor: "pointer",
												backgroundColor:
													chatItem.username == props.auth.username && "gold",
											}}
											className="rounded-0 border border-secondary border-right-0 border-top-0 border-bottom-0 p-2 my-1 mx-0"
											onClick={() => onDeleteChat(chatItem.id)}>
											<span style={{ color: "#232323" }}>
												<TrashSVG />
											</span>
										</div>
									)}
								{/* Trash End */}

								{/* Chat */}
								<div
									className="rounded-0 border-0 p-2 my-1 m-0 pb-0"
									style={{
										backgroundColor:
											chatItem.username == props.auth.username
												? "#FFD700"
												: "#232323",
										maxWidth: "90%",
										wordWrap: "break-word",
										cursor: "pointer",
									}}
									onClick={() => {
										if (chatItem.username == props.auth.username) {
											showDelete(chatItem.id)
										}
									}}>
									{chatItem.text}

									{/* Media */}
									<div className="mb-1" style={{ overflow: "hidden" }}>
										{chatItem.media && (
											<Img
												src={chatItem.media}
												width="100%"
												height="auto"
												alt={"chat-media"}
											/>
										)}
									</div>
									{/* Media End */}

									{/* Created At */}
									<small
										className={
											chatItem.username == props.auth.username
												? "text-dark m-0 p-1"
												: "text-muted m-0 p-1"
										}>
										<i
											style={{ fontSize: "0.8em" }}
											className="float-end m-0 p-0">
											{chatItem.createdAt}
										</i>
									</small>
									{/* Created At End */}
								</div>
								{/* Chat End */}
							</div>
						))}
				</div>
				<br />
				<br className="hidden" />
				<br className="hidden" />
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export default ChatThread
