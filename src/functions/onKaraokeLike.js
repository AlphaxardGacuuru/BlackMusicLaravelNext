import axios from "@/lib/axios"

const onKaraokeLike = (props) => {
	// Show like
	const newKaraokes = props.karaokes
		.filter((item) => {
			// Get the exact karaoke and change like status
			if (item.id == props.karaoke.id) {
				item.hasLiked = !item.hasLiked
			}
			return true
		})

	// Set new karaokes
	props.setKaraokes(newKaraokes)

	// Add like to database
	axios.post(`/api/karaoke-likes`, {
		karaoke: props.karaoke.id
	}).then((res) => {
		props.setMessages([res.data])
		// Update karaoke
		props.get("karaokes", props.setKaraokes)
	}).catch((err) => props.getErrors(err))
}

export default onKaraokeLike