import 'bootstrap/dist/css/bootstrap.css';
import '@/styles/dark.css'
import('next').NextConfig

import LoginPopUp from '@/components/auth/LoginPopUp';
import TopNav from '@/components/layouts/TopNav'
import BottomNav from '@/components/layouts/BottomNav'
import Messages from '@/components/core/Messages'

import React, { useState, useEffect, useRef } from 'react'
import axios from '@/lib/axios';

const App = ({ Component, pageProps }) => {

	const baseUrl = process.env.NEXT_PUBLIC_BACKEND_URL

	// Set Axios default header
	// axios.defaults.baseURL = "https://music.black.co.ke"

	// Function for checking local storage
	const getLocalStorage = (state) => {
		if (typeof window !== "undefined" && localStorage.getItem(state)) {
			return JSON.parse(localStorage.getItem(state))
		} else {
			return []
		}
	}

	// Function to set local storage
	const setLocalStorage = (state, data) => {
		localStorage.setItem(state, JSON.stringify(data))
	}

	const url = process.env.NEXT_PUBLIC_BACKEND_URL

	// Declare states
	const [messages, setMessages] = useState([])
	const [errors, setErrors] = useState([])
	const [login, setLogin] = useState()
	const [auth, setAuth] = useState(getLocalStorage("auth"))

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

	// Function for fetching data from API
	const get = (endpoint, setState, storage = null) => {
		axios.get(`/api/${endpoint}`)
			.then((res) => {
				var data = res.data ? res.data : []
				setState(data)
				storage && setLocalStorage(storage, data)
			}).catch(() => setErrors([`Failed to fetch ${endpoint}`]))
	}

	// Function for getting errors from responses
	const getErrors = (err, message = false) => {
		const resErrors = err.response.data.errors
		var newError = []
		for (var resError in resErrors) {
			newError.push(resErrors[resError])
		}
		// Get other errors
		message && newError.push(err.response.data.message)
		setErrors(newError)
	}

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

		get("auth", setAuth, "auth")
		get("audios", setAudios, "audios")
		get("audio-albums", setAudioAlbums, "audioAlbums")
		// get("audio-likes", setAudioLikes, "audioLikes")

		// get("bought-audios", setBoughtAudios, "boughtAudios")
		// get("bought-videos", setBoughtAudios, "boughtVideos")

		// get("cart-audios", setCartAudios, "cartAudios")
		get("cart-videos", setCartVideos, "cartVideos")

		// get("karaokes", setKaraokes, "karaokes")

		// get("posts", setPosts, "posts")
		get("users", setUsers, "users")

		get("videos", setVideos, "videos")
		get("video-albums", setVideoAlbums, "videoAlbums")
		// get("video-likes", setVideoLikes, "videoLikes")

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
		baseUrl,
		get, getErrors,
		getLocalStorage, setLocalStorage,
		login, setLogin,
		url,
		auth, setAuth,
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
			<Messages {...GLOBAL_STATE} />
		</div>
	)
}

export default App
