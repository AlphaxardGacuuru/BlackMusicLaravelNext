import 'bootstrap/dist/css/bootstrap.css';
import '@/styles/dark.css'
import('next').NextConfig

import { useAuth } from '@/hooks/auth'

import LoginPopUp from '@/components/Auth/LoginPopUp';
import TopNav from '@/components/Layouts/TopNav'
import BottomNav from '@/components/Layouts/BottomNav'

import React, { useState, useEffect, useRef } from 'react'
import axios from 'axios';

const App = ({ Component, pageProps }) => {

	// Set Axios default header
	axios.defaults.baseURL = "https://music.black.co.ke"

	// Function for checking local storage
	const getLocalStorage = (state) => {
		if (typeof window !== "undefined" && localStorage.getItem(state)) {
			return JSON.parse(localStorage.getItem(state))
		} else {
			return []
		}
	}

	const getLocalStorageAuth = (state) => {
		if (typeof window !== "undefined" && localStorage.getItem(state)) {
			return JSON.parse(localStorage.getItem(state))
		} else {
			return {
				"name": "Guest",
				"username": "@guest",
				"pp": "/storage/profile-pics/male_avatar.png",
				"account_type": "normal"
			}
		}
	}

	// Function to set local storage
	const setLocalStorage = (state, data) => {
		localStorage.setItem(state, JSON.stringify(data))
	}

	const url = process.env.NEXT_PUBLIC_BACKEND_URL

	const { auth } = useAuth()

	// Declare states
	const [login, setLogin] = useState()
	// const [auth, setAuth] = useState(getLocalStorageAuth("auth"))
	const [messages, setMessages] = useState([])
	const [errors, setErrors] = useState([])

	const [audios, setAudios] = useState(getLocalStorage("audios"))
	const [audioAlbums, setAudioAlbums] = useState(getLocalStorage("audioAlbums"))
	const [audioLikes, setAudioLikes] = useState(getLocalStorage("audioLikes"))

	const [boughtAudios, setBoughtAudios] = useState(getLocalStorage("boughtAudios"))
	const [boughtVideos, setBoughtVideos] = useState(getLocalStorage("boughtVideos"))

	const [cartAudios, setCartAudios] = useState(getLocalStorage("cartAudios"))
	const [cartVideos, setCartVideos] = useState(getLocalStorage("cartVideos"))

	const [karaokes, setKaraokes] = useState([])

	const [posts, setPosts] = useState(getLocalStorage("posts"))
	const [users, setUsers] = useState(getLocalStorage("users"))

	const [videos, setVideos] = useState(getLocalStorage("videos"))
	const [videoAlbums, setVideoAlbums] = useState(getLocalStorage("videoAlbums"))
	const [videoLikes, setVideoLikes] = useState(getLocalStorage("videoLikes"))

	// Reset Messages and Errors to null after 3 seconds
	if (errors.length > 0 || messages.length > 0) {
		setTimeout(() => setErrors([]), 2900);
		setTimeout(() => setMessages([]), 2900);
	}

	// Fetch data on page load
	useEffect(() => {
		// Import Js for Bootstrap
		import("bootstrap/dist/js/bootstrap");

		// Redirect if URL is not secure
		var unsecureUrl = window.location.href.match(/http:\/\/music.black.co.ke/)

		if (unsecureUrl) {
			window.location.href = 'https://music.black.co.ke'
		}

		// Fetch Auth
		axios.get(`/api/auth`)
			.then((res) => {
				// setAuth(res.data)
				// setLocalStorage("auth", res.data)
			}).catch(() => setErrors(["Failed to fetch auth"]))

		// Fetch Audios
		axios.get(`/api/audios`)
			.then((res) => {
				setAudios(res.data)
				setLocalStorage("audios", res.data)
			}).catch(() => setErrors(["Failed to fetch audios"]))

		// Fetch Audio Albums
		axios.get(`/api/audio-albums`)
			.then((res) => {
				setAudioAlbums(res.data)
				setLocalStorage("audioAlbums", res.data)
			}).catch(() => setErrors(["Failed to fetch audio albums"]))

		// Fetch Audio Likes
		axios.get(`/api/audio-likes`)
			.then((res) => {
				setAudioLikes(res.data)
				setLocalStorage("audioLikes", res.data)
			}).catch(() => setErrors(["Failed to fetch audio likes"]))

		// Fetch Bought Audios
		axios.get(`/api/bought-audios`)
			.then((res) => {
				setBoughtAudios(res.data)
				setLocalStorage("boughtAudios", res.data)
			}).catch(() => setErrors(['Failed to fetch bought audios']))

		// Fetch Bought Videos
		axios.get(`/api/bought-videos`)
			.then((res) => {
				setBoughtVideos(res.data)
				setLocalStorage("boughtVideos", res.data)
			}).catch(() => setErrors(['Failed to fetch bought videos']))

		// Fetch Cart Audios
		axios.get(`/api/cart-audios`)
			.then((res) => {
				setCartAudios(res.data)
				setLocalStorage("cartAudios", res.data)
			}).catch(() => setErrors(['Failed to fetch cart audios']))

		// Fetch Cart Videos
		axios.get(`/api/cart-videos`)
			.then((res) => {
				setCartVideos(res.data)
				setLocalStorage("cartVideos", res.data)
			}).catch(() => setErrors(['Failed to fetch cart videos']))

		// Fetch Karaokes
		axios.get(`/api/karaokes`)
			.then((res) => {
				setKaraokes(res.data)
				setLocalStorage("karaokes", res.data)
			}).catch(() => setErrors(["Failed to fetch karaokes"]))

		//Fetch Posts
		axios.get(`/api/posts`)
			.then((res) => {
				setPosts(res.data)
				setLocalStorage("posts", res.data)
			}).catch(() => setErrors(['Failed to fetch posts']))

		//Fetch Users
		axios.get(`/api/users`)
			.then((res) => {
				setUsers(res.data)
				setLocalStorage("users", res.data)
			}).catch(() => setErrors(['Failed to fetch users']))

		// Fetch Videos
		axios.get(`/api/videos`)
			.then((res) => {
				setVideos(res.data)
				setLocalStorage("videos", res.data)
			}).catch(() => setErrors(["Failed to fetch videos"]))

		// Fetch Video Albums
		axios.get(`/api/video-albums`)
			.then((res) => {
				setVideoAlbums(res.data)
				setLocalStorage("videoAlbums", res.data)
			}).catch(() => setErrors(["Failed to fetch video albums"]))

		// Fetch Video Likes
		axios.get(`/api/video-likes`)
			.then((res) => {
				setVideoLikes(res.data)
				setLocalStorage("videoLikes", res.data)
			}).catch(() => setErrors(["Failed to fetch video likes"]))

		// Fetch Karaokes
		axios.get(`/api/karaokes`)
			.then((res) => {
				setKaraokes(res.data)
			}).catch(() => setErrors(["Failed to fetch karaokes"]))

	}, [])

	console.log("rendered")

	/*
	*
	* Register service worker */
	if (typeof window !== "undefined" && window.location.href.match(/https/)) {
		if ('serviceWorker' in navigator) {
			window.addEventListener('load', () => {
				navigator.serviceWorker.register('/sw.js')
				// .then((reg) => console.log('Service worker registered', reg))
				// .catch((err) => console.log('Service worker not registered', err));
			})
		}
	}

	// All states
	const GLOBAL_STATE = {
		getLocalStorage, setLocalStorage,
		login, setLogin,
		url,
		auth, 
		// setAuth,
		messages, setMessages,
		errors, setErrors,
		audios, setAudios,
		audioAlbums, setAudioAlbums,
		audioLikes, setAudioLikes,
		boughtAudios, setBoughtAudios,
		boughtVideos, setBoughtVideos,
		cartAudios, setCartAudios,
		cartVideos, setCartVideos,
		karaokes, setKaraokes,
		posts, setPosts,
		users, setUsers,
		videoAlbums, setVideoAlbums,
		videos, setVideos,
		users, setUsers,
		videos, setVideos,
		videoAlbums, setVideoAlbums,
		videoLikes, setVideoLikes,
		karaokes, setKaraokes,
	}

	return (
		<div>
			<LoginPopUp {...GLOBAL_STATE} />
			<TopNav {...GLOBAL_STATE} />
			<Component {...pageProps} {...GLOBAL_STATE} />
			{/* <BottomNav {...GLOBAL_STATE} /> */}
		</div>
	)
}

export default App
