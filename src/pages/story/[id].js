import { useEffect } from "react"
import { useRouter } from "next/router"
import ssrAxios from "@/lib/ssrAxios"

import Story from "@/components/Story/Story"

const StoryShow = (props) => {
	const router = useRouter()

	let { id } = router.query

	useEffect(() => {
		// Scroll Karaoke to current one
		var storyEl = document.getElementById(id)

		storyEl && storyEl.scrollIntoView()
	}, [])

	return (
		<div className="row p-0">
			<div className="col-sm-4"></div>
			<div className="col-sm-4 m-0 p-0">
				<div
					className="hidden-scroll m-0 p-0"
					style={{ scrollSnapType: "x mandatory" }}>
					{props.stories.map((story, key) => (
						<Story key={key} story={story} />
					))}
				</div>
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export async function getServerSideProps(context) {
	var stories

	await ssrAxios.get(`/api/stories`).then((res) => (stories = res.data))

	return { props: { stories } }
}

export default StoryShow
