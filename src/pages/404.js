import SadEmojiSVG from "@/svgs/SadEmojiSVG"

const NotFoundPage = () => {
	return (
		<div
			style={{
				backgroundColor: "#232323",
				display: "flex",
				justifyContent: "center",
				alignItems: "center",
				textAlign: "center",
				minHeight: "100vh",
			}}>
			<center>
				<h1>404</h1>
				<hr className="text-white" />
				<h2>PAGE NOT FOUND</h2>
				<hr className="text-white" />
				<h3>
					SORRY <SadEmojiSVG />
				</h3>
			</center>
		</div>
	)
}

export default NotFoundPage
