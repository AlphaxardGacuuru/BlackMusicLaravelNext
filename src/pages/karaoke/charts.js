import React, { useState, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'
import axios from '@/lib/axios'

import Carousel from '@/components/core/Carousel'
import LoadingKaraokeMedia from '@/components/Karaoke/LoadingKaraokeMedia'
import KaraokeMedia from '@/components/Karaoke/KaraokeMedia'

// const KaraokeMedia = React.lazy(() => import('@/components/Karaoke/KaraokeMedia'))

import PlusSVG from '@/svgs/PlusSVG'

const KaraokeCharts = (props) => {

	const router = useRouter()

	const [karaokes, setKaraokes] = useState(props.data.karaokes)
	const [week, setWeek] = useState(0)
	const weeks = [0, 1, 2, 3, 4, 5]

	useEffect(() => {

		// Load more on page bottom
		window.onscroll = function (ev) {
			if (location.pathname.match(/karaoke-charts/)) {
				const bottom = (window.innerHeight + window.scrollY) >=
					(document.body.offsetHeight - document.body.offsetHeight / 16)

				if (bottom) {
					setVideoSlice(videoSlice + 8)
				}
			};
		}

	}, [])

	var checkLocation = true

	if (props.show != 0) {
		checkLocation = router.pathname.match(/audio-show/)
	}

	// Function for loading more artists
	const handleScroll = (e) => {
		const bottom = e.target.scrollLeft >= (e.target.scrollWidth - (e.target.scrollWidth / 3));

		if (bottom) {
			setArtistSlice(artistSlice + 10)
		}
	}

	// Dummy data for array
	var dummyArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

	return (
		<>
			<Link href={`/karaoke/create`}>
				<a id="chatFloatBtn"
					className={`${!checkLocation && "mb-5"}`}>
					<PlusSVG />
				</a>
			</Link>

			{/* Carousel */}
			<Carousel />
			<br />

			{/* <!-- Scroll menu - */}
			<div id="chartsMenu" className="hidden-scroll mt-2">
				<span>
					<Link href="/karaoke-charts">
						<h3 className="active-scrollmenu">Karaoke</h3>
					</Link>
				</span>
				<span>
					<Link href="/video/charts">
						<h3>Videos</h3>
					</Link>
				</span>
				<span>
					<Link href="/audio/charts">
						<h3>Audios</h3>
					</Link>
				</span>
			</div>

			{/* Week */}
			<div id="chartsMenu" className="hidden-scroll m-0">
				{weeks.map((weekItem, key) => (
					<span key={key}>
						<a href="#" onClick={(e) => {
							e.preventDefault()
							setWeek(weekItem++)
						}}>
							<h5 className={week == weekItem ?
								"active-scrollmenu m-0" :
								"m-0"}>
								{weekItem == 0 ?
									"This Week" :
									weekItem == 1 ?
										"Last week" :
										weekItem + " weeks ago"}
							</h5>
						</a>
					</span>
				))}
			</div>
			{/* Week End */}

			<div className="row">
				<div className="col-sm-12">
					{/* Karaoke Items */}
					<div className="d-flex flex-wrap justify-content-center" onScroll={handleScroll}>
						{/* Loading Karaoke Media */}
						{dummyArray
							.filter(() => karaokes.length < 1)
							.map((item, key) => (<LoadingKaraokeMedia key={key} />))}
						{/* Loading Karaoke Media End */}

						{karaokes
							.map((karaoke, key) => (
								<KaraokeMedia
									key={key}
									setShow={props.setShow}
									link={`/karaoke-show/${karaoke.id}`}
									src={`/storage/${karaoke.karaoke}`}
									name={karaoke.name}
									username={karaoke.username}
									avatar={karaoke.avatar} />
							))}
					</div>
					{/* Karaoke Items End */}
				</div>
			</div>
		</>
	)
}

// This gets called on every request
export async function getServerSideProps() {
	// Fetch data from external API
	var data = {
		karaokes: null,
	}

	// Fetch Karaokes
	await axios.get(`/api/karaokes`)
		.then((res) => data.karaokes = res.data)

	// Pass data to the page via props
	return { props: { data } }
}

export default KaraokeCharts