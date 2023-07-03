import Document, { Html, Head, Main, NextScript } from 'next/document'
import Script from 'next/script'

class MyDocument extends Document {

	static async getInitialProps(ctx) {
		const initialProps = await Document.getInitialProps(ctx)
		return { ...initialProps }
	}

	render() {
		return (
			<Html>
				<Head>
					<meta charset="utf-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1" />
					{/* {{-- Change address bar color Chrome, Firefox OS and Opera --}} */}
					<meta name="theme-color" content="#232323" />
					{/* {{-- iOS Safari --}} */}
					<meta name="apple-mobile-web-app-status-bar-style" content="#232323" />
					<meta name="description" content="The best Kenyan Online Music Store" />

					{/* <!-- CSRF Token --> */}
					<meta name="csrf-token" content="{{ csrf_token() }}" />

					<title>Black Music</title>

					{/* <!-- Favicon  --> */}
					<link rel="icon" href="/storage/img/musical-note.png" />

					{/* <!-- Fonts --> */}
					<link rel="dns-prefetch" href="//fonts.gstatic.com" />
					<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />
					<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet" />

					{/* {{-- Manifest --}} */}
					<link rel="manifest" type="application/manifest+json" href="/manifest.webmanifest" />

					{/* {{-- IOS support --}} */}
					<link rel="apple-touch-icon" href="/storage/img/musical-note.png" />
					<meta name="apple-mobile-web-app-status-bar" content="#aa7700" />

					<link
						href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
						rel="stylesheet"
						integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
						crossOrigin="anonymous" />
				</Head>
				<body className="antialiased">
					<noscript>
						<center>
							<h2 className="m-5">
								We're sorry but Black Music
								doesn't work properly without JavaScript enabled.
								Please enable it to continue.
							</h2>
						</center>
					</noscript>
					<Main />
					<NextScript />
					{/* Global site tag (gtag.js) - Google Analytics */}
					<Script async src="https://www.googletagmanager.com/gtag/js?id=G-5K64MQR0RL" strategy="lazyOnload"></Script>
					<Script strategy="lazyOnload">
						{`window.dataLayer = window.dataLayer || [];

							function gtag() {
								dataLayer.push(arguments);
        					}
							gtag('js', new Date());

							gtag('config', 'G-5K64MQR0RL');`}
					</Script>
				</body>
			</Html>
		)
	}
}

export default MyDocument
