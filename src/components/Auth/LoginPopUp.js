import { useState } from 'react'
import { useRouter } from 'next/router';
import axios from '@/lib/axios'
import { useAuth } from '@/hooks/auth'

import Btn from '@/components/core/Btn'

import CloseSVG from '@/svgs/CloseSVG';

import {
	GoogleLoginButton,
	FacebookLoginButton,
	TwitterLoginButton
} from "react-social-login-buttons";

const LoginPopUp = (props) => {

	const { register, authenticated } = useAuth({
		middleware: 'guest',
		redirectIfAuthenticated: '/',
	})

	const { login } = useAuth({
		middleware: 'guest',
		redirectIfAuthenticated: '/',
		setLogin: props.setLogin
	})

	const router = useRouter()

	// const [name, setName] = useState('Alphaxard Gacuuru')
	const [name, setName] = useState('Black Music')
	// const [username, setUsername] = useState('@alphaxardG')
	const [username, setUsername] = useState('@blackmusic')
	// const [email, setEmail] = useState('alphaxardgacuuru47@gmail.com')
	const [email, setEmail] = useState('al@black.co.ke')
	// const [phone, setPhone] = useState('0700364446')
	const [phone, setPhone] = useState('0700000000')
	// const [password, setPassword] = useState('0700364446')
	const [password, setPassword] = useState('0700000000')
	const [shouldRemember, setShouldRemember] = useState()
	const [status, setStatus] = useState()
	const [errors, setErrors] = useState([])

	const onSocial = (website) => {
		// window.location.href = `${props.url}/api/login/${website}`

		// axios.get(`${props.url}/api/login/${website}`)
		// .then((res) => console.log(res.data))

		// register({ name, username, email, phone, password, password_confirmation: password, setErrors })

		login({ username, phone, email, password, remember: shouldRemember, setErrors, setStatus })
	}

	// const [phone, setPhone] = useState('07')
	const [phoneLogin, setPhoneLogin] = useState(false)

	const onSubmit = (e) => {
		e.preventDefault()

		axios.get('/sanctum/csrf-cookie').then(() => {
			axios.post(`${props.url}/api/login`, {
				phone: phone,
				password: phone,
				remember: 'checked'
			}).then((res) => {
				props.setLogin(false)
				props.setMessages(["Logged in"])
				// Update Logged in user
				axios.get(`${props.url}/api/auth`)
					.then((res) => props.setAuth(res.data))
				// Save phone to Local Storage
				localStorage.setItem("phone", phone)
				// Reload page
				setTimeout(() => location.reload(), 1000)
			}).catch(err => {
				const resErrors = err.response.data.errors
				// Get validation errors
				var resError
				var newError = []
				for (resError in resErrors) {
					newError.push(resErrors[resError])
				}
				// Get other errors
				newError.push(err.response.data.message)
				props.setErrors(newError)
			});
		});

		setPhone('07')
	}

	return (
		<>
			<div id="preloader" style={{ display: props.login ? "block" : "none" }}>
				<div className="preload-content">
					{/* <div id="sonar-load"></div> */}
				</div>
			</div>
			<div className="menu-open" style={{ display: props.login ? "block" : "none" }}>
				<div className="bottomMenu">
					<div className="d-flex align-items-center justify-content-between">
						{/* <!-- Logo Area --> */}
						<div className="logo-area p-2">
							<a href="#">Login</a>
						</div>
						{/* <!-- Close Icon --> */}
						<div
							className="closeIcon float-end"
							style={{ fontSize: "1em" }}
							onClick={() => {
								props.setLogin(false)
								router.push("/")
							}}>
							<CloseSVG />
						</div>
					</div>
					<div className="p-2">
						{phoneLogin ?
							<center>
								<div className="contact-form">
									<form method="POST" action="" onSubmit={onSubmit}>
										<input
											id="phone"
											type="text"
											className="form-control"
											name="phone"
											value={phone}
											onChange={(e) => setPhone(e.target.value)}
											required={true}
											autoComplete="phone"
											autoFocus />
										<br />

										<Btn type="submit"
											btnClass="mysonar-btn float-right"
											btnText="Login" />
									</form>
									<br />
									<br />

									<Btn
										btnClass="mysonar-btn"
										btnText="back"
										onClick={() => setPhoneLogin(false)} />
								</div>
							</center> :
							<>
								<GoogleLoginButton
									className="mt-2 rounded-0"
									onClick={() => onSocial("google")} />
								<FacebookLoginButton
									className="mt-2 rounded-0"
									onClick={() => onSocial("facebook")} />
								<TwitterLoginButton
									className="mt-2 rounded-0"
									onClick={() => onSocial("twitter")} />
								<br />

								<Btn
									btnClass="mysonar-btn"
									btnText="login with number"
									onClick={() => setPhoneLogin(true)} />
							</>}
					</div>
				</div>
			</div>
		</>
	)
}

export default LoginPopUp