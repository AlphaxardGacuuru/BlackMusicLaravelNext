import SadEmojiSVG from "@/svgs/SadEmojiSVG"

const NotFoundPage = () => {
	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				<div
					className="mt-5 p-5 rounded-0"
					style={{ backgroundColor: "#232323" }}>
					<center>
						<h1 className="mt-3">404</h1>
						<h2 className="mt-3">
							Sorry{" "}
							<SadEmojiSVG />
						</h2>
						<h3 className="mt-3">Page not found</h3>
					</center>
				</div>
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export default NotFoundPage
