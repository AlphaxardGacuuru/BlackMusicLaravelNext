import "bootstrap/dist/css/bootstrap.css"
import "@/styles/dark.css"
// import("next").NextConfig

import React, { useState, useEffect, useRef } from "react"
import axios from "@/lib/axios"

import LoginPopUp from "@/components/Auth/LoginPopUp"
import TopNav from "@/components/Layouts/TopNav"
import BottomNav from "@/components/Layouts/BottomNav"
import Messages from "@/components/Core/Messages"
import AudioPlayer from "@/components/Audio/AudioPlayer"
import onAudioPlayer from "@/functions/onAudioPlayer"

const App = ({ Component, pageProps }) => {
	/*
	 *
	 * Register service worker */
	if (typeof window !== "undefined" && window.location.href.match(/https/)) {
		if ("serviceWorker" in navigator) {
			window.addEventListener("load", () => {
				navigator.serviceWorker.register("/sw.js")
				// .then((reg) => console.log('Service worker registered', reg))
				// .catch((err) => console.log('Service worker not registered', err));
			})
		}
	}

	const baseUrl = process.env.NEXT_PUBLIC_BACKEND_URL

	// Function for checking local storage
	const getLocalStorage = (state) => {
		if (typeof window !== "undefined" && localStorage.getItem(state)) {
			return JSON.parse(localStorage.getItem(state))
		} else {
			return []
		}
	}

	// Function for checking local storage
	const getLocalStorageAuth = (state) => {
		if (typeof window !== "undefined" && localStorage.getItem(state)) {
			return JSON.parse(localStorage.getItem(state))
		} else {
			return {
				name: "Guest",
				username: "@guest",
				avatar: "/storage/avatars/male-avatar.png",
				accountType: "normal",
				decos: 0,
				posts: 0,
				fans: 0,
			}
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
	const [auth, setAuth] = useState(getLocalStorageAuth("auth"))
	const [cartVideos, setCartVideos] = useState([])
	const [cartAudios, setCartAudios] = useState([])
	// Search State
	const [search, setSearch] = useState("!@#$%^&")
	const searchInput = useRef(null)

	// Function for fetching data from API
	const get = (endpoint, setState, storage = null, errors = true) => {
		axios
			.get(`/api/${endpoint}`)
			.then((res) => {
				var data = res.data ? res.data : []
				setState(data)
				storage && setLocalStorage(storage, data)
			})
			.catch(() => errors && setErrors([`Failed to fetch ${endpoint}`]))
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

	// Fetch data on page load
	useEffect(() => {
		// Import Js for Bootstrap
		import("bootstrap/dist/js/bootstrap")

		// Redirect if URL is not secure
		var unsecureUrl = window.location.href.match(/http:\/\/music.black.co.ke/)

		if (unsecureUrl) {
			window.location.href = "https://music.black.co.ke"
		}

		get("auth", setAuth, "auth", false)
		get("cart-videos", setCartVideos, "cartVideos")
		get("cart-audios", setCartAudios, "cartAudios")
	}, [])

	const audioStates = onAudioPlayer(getLocalStorage, get, setErrors, auth)

	// Function to focus on search input
	const onSearchIconClick = () => {
		window.location.href.match("/search") && searchInput.current.focus()
	}

	// All states
	const GLOBAL_STATE = {
		baseUrl,
		get,
		getErrors,
		getLocalStorage,
		setLocalStorage,
		login,
		setLogin,
		url,
		auth,
		setAuth,
		messages,
		setMessages,
		errors,
		setErrors,
		// Search
		onSearchIconClick,
		searchInput,
		search,
		setSearch,
		cartVideos,
		setCartVideos,
		cartAudios,
		setCartAudios,
		// Audio Player
		audioStates,
	}

	return (
		<div>
			<LoginPopUp {...GLOBAL_STATE} />
			<TopNav {...GLOBAL_STATE} />
			<Component {...pageProps} {...GLOBAL_STATE} />
			<BottomNav {...GLOBAL_STATE} />
			<Messages {...GLOBAL_STATE} />
			<AudioPlayer {...GLOBAL_STATE} />
		</div>
	)
}

export default App
