const onShare = (props) => {
// Web Share API for share button
// Share must be triggered by "user activation"

	// Define share data
	const shareData = {
		title: props.karaoke.audio,
		text: props.text,
		url: `https://music.black.co.ke/#/karaoke-show/${props.karaoke.id}`
	}
	// Check if data is shareble
	navigator.canShare(shareData) &&
		navigator.share(shareData)
}

export default onShare