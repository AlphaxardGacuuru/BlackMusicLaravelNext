import React from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'

// import SocialMediaInput from './SocialMediaInput'

import CloseSVG from '@/svgs/CloseSVG';
import PreviousSVG from '@/svgs/PreviousSVG';
import PauseSVG from '@/svgs/PauseSVG';
import PlaySVG from '@/svgs/PlaySVG';
import NextSVG from '@/svgs/NextSVG';
import HomeSVG from '@/svgs/HomeSVG';
import DiscoverSVG from '@/svgs/DiscoverSVG';
import SearchSVG from '@/svgs/SearchSVG';
import CartSVG from '@/svgs/CartSVG';
import PersonSVG from '@/svgs/PersonSVG';

const Bottomnav = (props) => {

	const router = useRouter()

	var display
	var inputDisplay
	var checkLocation = true
	var isInKaraoke = false

	// Hide BottomNav from various pages
	router.pathname.match("/karaoke-show") ||
		router.pathname.match("/karaoke-create") ||
		router.pathname.match("/privacy-policy") ||
		router.pathname.match("/download-app") ||
		router.pathname.match("/chat/") ||
		router.pathname.match("/post-edit") ||
		router.pathname.match("/post-create") ||
		router.pathname.match("/post-show/") ||
		router.pathname.match("/referral") ||
		router.pathname.match("/login") ||
		router.pathname.match("/register") ?
		display = "none" : display = ""

	// Show Social Input in various pages
	router.pathname.match("/post-show/") ||
		router.pathname.match("/chat/") ?
		inputDisplay = "" : inputDisplay = "none"

	// Check if audio is in queue and location is in audio show
	if (props.show != 0) {
		checkLocation = router.pathname.match(/audio-show/)
	}

	// Check if location is in Karaoke
	isInKaraoke = router.pathname.match("/karaoke-show") ||
		router.pathname.match("/karaoke-create")

	// Get number of items in video cart
	const vidCartItems = props.cartVideos.filter((cartVideo) => cartVideo.username == props.auth?.username).length
	const audCartItems = props.cartAudios.filter((cartAudio) => cartAudio.username == props.auth?.username).length
	const cartItems = vidCartItems + audCartItems

	return (
		<>
			{/* Add breaks if social input is visible */}
			<br style={{ display: !props.showSocialInput && "none" }} />
			<br style={{ display: !props.showSocialInput && "none" }} />
			{/* Add breaks if audio player is visible */}
			<br style={{ display: checkLocation && "none" }} />
			<br style={{ display: checkLocation && "none" }} />
			<br style={{ display: checkLocation && "none" }} />
			<br style={{ display: isInKaraoke && "none" }} className="anti-hidden" />
			<br style={{ display: isInKaraoke && "none" }} className="anti-hidden" />
			<div className="bottomNav menu-content-area header-social-area">
				{/* <!-- Progress Container --> */}
				<div
					ref={props.audioContainer}
					className="progress"
					style={{
						height: "3px",
						background: "#232323",
						borderRadius: "0px",
						display: checkLocation && "none"
					}}>
					<div
						ref={props.audioProgress}
						className="progress-bar rounded-0"
						style={{
							background: "#FFD700",
							height: "5px",
							width: props.progressPercent
						}}>
					</div>
				</div>

				{/* Audio Player */}
				<div className="container-fluid menu-area d-flex text-white hidden px-1 border-bottom border-dark">
					{/* <!-- Close Icon --> */}
					<div
						className="px-0 align-self-center"
						style={{ display: checkLocation && "none" }}>
						<span
							onClick={() => {
								props.setShow(0)
								props.setLocalStorage("show", "")
							}}>
							<CloseSVG />
						</span>
					</div>
					{/* Audio Details */}
					<div className="p-2 me-auto align-self-center" style={{ display: checkLocation && "none" }} >
						<Link to={`/audio-show/${props.show}`}>
							<h6
								className="mb-0 pb-0"
								style={{
									maxWidth: "14em",
									whiteSpace: "nowrap",
									overflow: "hidden",
									textOverflow: "clip",
									color: "white"
								}}>
								{props.showAudio.name}
							</h6>
							<h6 className="my-0 pt-0" style={{ color: "white" }}>
								<small>{props.showAudio.username}</small>
								<small className="ms-1">{props.showAudio.ft}</small>
							</h6>
						</Link>
					</div>
					{/* Loader */}
					{props.audioLoader &&
						<div className="align-self-center" style={{ padding: "10px", display: checkLocation && "none" }}>
							<div className="spinner-border text-light"
								style={{
									borderTopWidth: "2px",
									borderBottomWidth: "2px",
									borderLeftWidth: "2px",
									width: "20px",
									height: "20px",
								}}>
							</div>
						</div>}
					{/* Previous */}
					<div
						style={{
							cursor: "pointer",
							display: checkLocation && "none"
						}}
						className="p-2 align-self-center">
						<span onClick={props.prevSong}><PreviousSVG /></span>
					</div>
					{/* Play / Pause */}
					<div
						style={{
							cursor: "pointer",
							display: checkLocation && "none",
							color: "#FFD700"
						}}
						className="p-1 align-self-center">
						<span style={{ fontSize: "2em" }} onClick={props.playBtn ? props.pauseSong : props.playSong}>
							{props.playBtn ? <PauseSVG /> : <PlaySVG />}
						</span>
					</div>
					{/* Next */}
					<div
						style={{
							cursor: "pointer",
							display: checkLocation && "none"
						}}
						className="p-2 align-self-center">
						<span onClick={props.nextSong}><NextSVG /></span>
					</div>
				</div>
				{/* Audio Player End */}

				{/* Social Input */}
				<form
					onSubmit={props.onSubmit}
					className="contact-form bg-white"
					style={{ display: inputDisplay }}
					autoComplete="off">
					{/* <SocialMediaInput {...props} /> */}
				</form>

				{/* Bottom Nav */}
				<div className="anti-hidden" style={{ display: display }}>
					<div className="container-fluid menu-area d-flex justify-content-between">
						{/* Home */}
						<Link
							to="/"
							style={{
								textAlign: "center",
								fontSize: "10px",
								fontWeight: "100"
							}}>
							<span
								style={{
									fontSize: "20px",
									margin: "0",
									color: router.pathname == "/" ? "gold" : "white"
								}}
								className="nav-link">
								<HomeSVG />
							</span>
						</Link>
						{/* Home End */}
						{/* Discover */}
						<Link
							to="/karaoke-charts"
							style={{
								textAlign: "center",
								fontSize: "10px",
								fontWeight: "100"
							}}>
							<span
								style={{
									fontSize: "20px",
									color: router.pathname == "/karaoke-charts" ||
										router.pathname == "/video-charts" ||
										router.pathname == "/audio-charts" ?
										"gold" : "white"
								}} className="nav-link">
								<DiscoverSVG />
							</span>
						</Link>
						{/* Discover End */}
						{/* Search */}
						<Link
							to="/search"
							style={{
								color: "white",
								textAlign: "center",
								fontSize: "10px",
								fontWeight: "100"
							}}
							onClick={props.onSearchIconClick}>
							<span
								style={{
									fontSize: "20px",
									color: router.pathname == "/search" ? "gold" : "white"
								}} className="nav-link">
								<SearchSVG />
							</span>
						</Link>
						{/* Search End */}
						{/* Cart */}
						<Link to="/cart"
							style={{
								textAlign: "center",
								fontSize: "10px",
								fontWeight: "100",
								position: "relative"
							}}>
							<span
								style={{
									fontSize: "20px",
									color: router.pathname == "/cart" ? "gold" : "white"
								}}
								className="nav-link">
								<CartSVG />
							</span>
							<span className="badge badge-danger rounded-circle"
								style={{
									fontSize: "12px",
									fontWeight: "100",
									position: "absolute",
									right: "-0.3rem",
									bottom: "1rem",
									border: "solid #232323"
								}}>
								{cartItems > 0 && cartItems}
							</span>
						</Link>
						{/* Cart End */}
						{/* Library */}
						<Link
							to="/library"
							style={{
								textAlign: "center",
								fontSize: "10px",
								fontWeight: "100"
							}}>
							<span
								style={{
									fontSize: "23px",
									color: router.pathname == "/library" ? "gold" : "white"
								}}
								className="nav-link">
								<PersonSVG />
							</span>
						</Link>
						{/* Library End */}
					</div>
				</div>
				{/* Bottom Nav End */}
			</div>
		</>
	)
}

export default Bottomnav
