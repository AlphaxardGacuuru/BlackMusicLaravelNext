import axios from "@/lib/axios"

const onKaraokeSave = (props) => {
	// Show Save
	const newKaraokes = props.karaokes
		.filter((item) => {
			// Get the exact karaoke and change save status
			if (item.id == props.karaoke.id) {
				item.hasSaved = !item.hasSaved
			}
			return true
		})
	// Set new karaokes
	props.setKaraokes(newKaraokes)

	// Save Karaoke
	axios.post('api/saved-karaokes', {
		id: props.karaoke.id
	}).then((res) => {
		props.setMessages([res.data])
		// Update karaoke
		props.get("karaokes", props.setKaraokes)
	}).catch((err) => props.getErrors(err))
}

export default onKaraokeSave