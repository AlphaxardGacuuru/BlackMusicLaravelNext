import React from 'react'
import Link from 'next/link'
import Image from 'next/image'
import Img from '@/components/core/Img'

import PersonSVG from '@/svgs/PersonSVG'
import CartSVG from '@/svgs/CartSVG'
import BellSVG from '@/svgs/BellSVG'
import LogoutSVG from '@/svgs/LogoutSVG'
import DownloadSVG from '@/svgs/DownloadSVG'
import PrivacySVG from '@/svgs/PrivacySVG'
import SettingsSVG from '@/svgs/SettingsSVG'
import StudioSVG from '@/svgs/StudioSVG'

const TopNavLinks = (props) => {
	return (
		<>
			{/* Admin */}
			{props.auth?.username == "@blackmusic" &&
				<Link href="/admin">
					<a className="me-3">
						<PersonSVG />
					</a>
				</Link>}

			{/* Cart */}
			<div className="dropdown me-3 hidden">
				<Link href="/cart">
					<a
						role="button"
						id="dropdownMenua"
						// data-toggle="dropdown"
						aria-haspopup="true"
						aria-expanded="false"
						style={{
							textAlign: "center",
							fontWeight: "100",
							position: "relative",
						}}>
						<CartSVG />
					</a>
				</Link>
				<span className="badge badge-danger rounded-circle hidden"
					style={{
						fontWeight: "100",
						position: "absolute",
						right: "-0.5rem",
						bottom: "0.5rem",
						border: "solid #232323"
					}}>
					{props.cartItems > 0 && props.cartItems}
				</span>
			</div>
			{/* Cart End */}

			{/* Notification Dropdown */}
			<div className="dropdown me-3">
				<Link href="#">
					<a
						role="button"
						id="dropdownMenua"
						className="hidden"
						data-toggle="dropdown"
						aria-haspopup="true"
						aria-expanded="false"
						style={{
							textAlign: "center",
							fontWeight: "100",
							position: "relative",
						}}
						onClick={props.onNotification}>
						<BellSVG />
					</a>
				</Link>
				{/* For smaller screens */}
				<span
					className="anti-hidden m-2"
					style={{
						textAlign: "center",
						fontWeight: "100",
						position: "relative",
					}}
					onClick={() => {
						props.setBottomMenu("menu-open")
						props.setNotificationVisibility("block")
						props.setAvatarVisibility("none")
						props.onNotification()
					}}>
					<BellSVG />
				</span>
				<span className="badge badge-danger rounded-circle"
					style={{
						fontWeight: "100",
						position: "absolute",
						right: "-0.5rem",
						bottom: "0.5rem",
						border: "solid #232323"
					}}>
					{props.notifications.filter((notification) => !notification.isRead).length > 0 &&
						props.notifications.filter((notification) => !notification.isRead).length}
				</span>
				<div
					style={{ borderRadius: "0", backgroundColor: "#232323" }}
					className="dropdown-menu dropdown-menu-right m-0 p-0"
					aria-labelledby="dropdownMenuButton">
					<div className="dropdown-header border-bottom border-dark">Notifications</div>
					<div style={{ maxHeight: "500px", overflowY: "scroll" }}>
						{/* Get Notifications */}
						{props.notifications
							.map((notification, key) => (
								<Link key={key} href={notification.url}>
									<a
										className="p-2 dropdown-item border-bottom text-dark border-dark"
									// onClick={() => props.onDeleteNotifications(notification.id)}
									>
										<small>{notification.message}</small>
									</a>
								</Link>
							))}
					</div>
					{props.notifications.length > 0 &&
						<div
							className="dropdown-header"
							style={{ cursor: "pointer" }}
							onClick={() => props.onDeleteNotifications(0)}>
							Clear notifications
						</div>}
				</div>
			</div>
			{/* Notification Dropdown End */}

			{/* Avatar Dropdown */}
			<div className="dropdown-center mt-2">
				<a
					href="#"
					role="button"
					className="hidden"
					data-bs-toggle="dropdown"
					aria-expanded="false">
					<Image
						src={props.auth?.avatar}
						className="rounded-circle"
						width="25px"
						height="25px"
						alt="Avatar" />
				</a>
				{/* For small screens */}
				<span
					className="anti-hidden mt-2"
					onClick={() => {
						props.setBottomMenu(props.bottomMenu == "menu-open" ? "" : "menu-open")
						props.setAvatarVisibility("block")
						props.setNotificationVisibility("none")
					}}>
					<Img
						src={props.auth?.avatar}
						imgClass="rounded-circle anti-hidden"
						width="25px"
						height="25px"
						alt="Avatar" />
				</span>
				<div
					style={{ backgroundColor: "#232323" }}
					className="dropdown-menu rounded-0 m-0 p-0">
					<Link href={`/profile/${props.auth?.username}`}>
						<a className="p-3 dropdown-item border-bottom border-dark">
							<div className="d-flex">
								<div className="align-items-center">
									<Img
										src={props.auth?.avatar}
										imgClass="rounded-circle"
										width="25px"
										height="25px"
										alt="Avatar" />
								</div>
								<div className="ps-2">
									<h5>{props.auth?.name}</h5>
									<h6>{props.auth?.username}</h6>
								</div>
							</div>
						</a>
					</Link>
					<Link href="/download-app">
						<a
							className="p-3 dropdown-item border-bottom border-dark"
							style={{ display: props.downloadLink ? "block" : "none" }}>
							<h6><span className="me-2"><DownloadSVG /></span>Get App</h6>
						</a>
					</Link>
					<Link href='/video'>
						<a className="p-3 dropdown-item border-bottom border-dark">
							<h6><span className="me-2"><StudioSVG /></span>Studio</h6>
						</a>
					</Link>
					<Link href='/settings'>
						<a className="p-3 dropdown-item border-bottom border-dark">
							<h6><span className="me-2"><SettingsSVG /></span>Settings</h6>
						</a>
					</Link>
					<Link href="/privacy-policy">
						<a
							className="p-3 dropdown-item border-bottom border-dark"
							title="Privacy Policy">
							<h6><span className="me-2"><PrivacySVG /></span>Privacy Policy</h6>
						</a>
					</Link>
					<Link href="#">
						<a
							className="p-3 dropdown-item"
							onClick={(e) => props.logout(e)}>
							<h6><span className="me-2"><LogoutSVG /></span>Logout</h6>
						</a>
					</Link>
				</div>
			</div>
			{/* Avatar Dropdown End */}
		</>
	)
}

export default TopNavLinks
