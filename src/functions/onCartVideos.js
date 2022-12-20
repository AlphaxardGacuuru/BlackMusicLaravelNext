import axios from '@/lib/axios'

// Function for adding video to cart
const onCartVideos = (props) => {

	// Change cart button
	const newVideos = props.videos
		.filter((item) => {
			// Get the exact video and change cart button
			if (item.id == props.video.id) {
				item.inCart = !item.inCart
			}
			return true
		})

	// Set new Videos
	props.setVideos(newVideos)

	// Change delete from cart button for cart videos
	const newCartVideos = props.cartVideos
		.filter((item) => {
			// Get the exact video
			if (item.video_id == props.video.id) {
				return false
			} else {
				return true
			}
		})

	// Set new Cart Videos
	props.setCartVideos(newCartVideos)

	// Add Video to Cart
	axios.post(`/api/cart-videos`, {
		video: props.video.id
	}).then((res) => {
		props.setMessages([res.data])
		// Update Videos
		props.get("videos", props.setVideos, "videos")
		// Update Cart Videos
		props.get("cart-videos", props.setCartVideos, "cartVideos")
		// Update Video Albums
		props.get("video-albums", props.setVideoAlbums, "videoAlbums")
	}).catch((err) => props.getErrors(err, true))
}

export default onCartVideos