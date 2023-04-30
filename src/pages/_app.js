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
				avatar: "/storage/profile-pics/male_avatar.png",
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

	// Social Input states
	const [id, setId] = useState()
	const [to, setTo] = useState()
	const [placeholder, setPlaceholder] = useState()
	const [text, setText] = useState("")
	const [media, setMedia] = useState("")
	const [para1, setPara1] = useState("")
	const [para2, setPara2] = useState("")
	const [para3, setPara3] = useState("")
	const [para4, setPara4] = useState("")
	const [para5, setPara5] = useState("")
	const [urlTo, setUrlTo] = useState()
	const [urlToTwo, setUrlToTwo] = useState()
	const [stateToUpdate, setStateToUpdate] = useState()
	const [stateToUpdateTwo, setStateToUpdateTwo] = useState()
	const [showImage, setShowImage] = useState()
	const [showPoll, setShowPoll] = useState()
	const [showMentionPicker, setShowMentionPicker] = useState(false)
	const [showEmojiPicker, setShowEmojiPicker] = useState(false)
	const [showImagePicker, setShowImagePicker] = useState(false)
	const [showPollPicker, setShowPollPicker] = useState(false)
	const [editing, setEditing] = useState(false)

	const [formData, setFormData] = useState()

	useEffect(() => {
		// Declare new FormData object for form data
		setFormData(new FormData())
	}, [])

	// Handle form submit for Social Input
	const onSubmit = (e) => {
		e.preventDefault()

		// Add form data to FormData object
		formData.append("text", text)
		id && formData.append("id", id)
		to && formData.append("to", to)
		media && formData.append("media", media)
		para1 && formData.append("para1", para1)
		para2 && formData.append("para2", para2)
		para3 && formData.append("para3", para3)
		para4 && formData.append("para4", para4)
		para5 && formData.append("para5", para5)
		editing && formData.append("_method", "put")

		// Get csrf cookie from Laravel inorder to send a POST request
		axios
			.post(`/api/${urlTo}`, formData)
			.then((res) => {
				setMessages([res.data])
				// Clear Media
				setMedia("")
				// Updated State One
				get(urlTo, stateToUpdate)
				// Updated State Two
				urlToTwo &&
					axios
						.get(`/api/${urlToTwo}`)
						.then((res) => stateToUpdateTwo(res.data))
				// Clear text unless editing
				!editing && setText("")
				setShowMentionPicker(false)
				setShowEmojiPicker(false)
				setShowImagePicker(false)
				setShowPollPicker(false)
			})
			.catch((err) => getErrors(err))
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
		// Social Input
		id,
		setId,
		to,
		setTo,
		text,
		setText,
		media,
		setMedia,
		para1,
		setPara1,
		para2,
		setPara2,
		para3,
		setPara3,
		para4,
		setPara4,
		para5,
		setPara5,
		placeholder,
		setPlaceholder,
		urlTo,
		setUrlTo,
		urlToTwo,
		setUrlToTwo,
		stateToUpdate,
		setStateToUpdate,
		stateToUpdateTwo,
		setStateToUpdateTwo,
		showImage,
		setShowImage,
		showPoll,
		setShowPoll,
		showMentionPicker,
		setShowMentionPicker,
		showEmojiPicker,
		setShowEmojiPicker,
		showImagePicker,
		setShowImagePicker,
		showPollPicker,
		setShowPollPicker,
		editing,
		setEditing,
		onSubmit,
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
