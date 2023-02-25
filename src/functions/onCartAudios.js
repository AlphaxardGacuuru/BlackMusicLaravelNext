import axios from '@/lib/axios'

// Function for adding audio to cart
const onCartAudios = (props) => {

	// Change cart button
	const newAudios = props.audios
		.filter((item) => {
			// Get the exact audio and change cart button
			if (item.id == props.audio.id) {
				item.inCart = !item.inCart
			}
			return true
		})

	// Set new Audios
	props.setAudios(newAudios)

	// Change delete from cart button for cart audios
	const newCartAudios = props.cartAudios
		.filter((item) => {
			// Get the exact audio
			if (item.audioId == props.audio.id) {
				return false
			} else {
				return true
			}
		})

	// Set new Cart Audios
	props.setCartAudios(newCartAudios)

	// Add Audio to Cart
	axios.post(`/api/cart-audios`, {
		audio: props.audio.id
	}).then((res) => {
		props.setMessages([res.data])
		// Update Audios
		props.get("audios", props.setAudios, "audios")
		// Update Cart Audios
		props.get("cart-audios", props.setCartAudios, "cartAudios")
		// Update Audio Albums
		props.get("audio-albums", props.setAudioAlbums, "audioAlbums")
	}).catch((err) => props.getErrors(err, true))
}

export default onCartAudios