const LoadingKaraokeMedia = () => {
	return (
		<div
			className="m-1"
			style={{
				borderRadius: "0px",
				textAlign: "center",
				color: "#232323",
			}}>
			<div className="karaoke-thumbnail gradient" style={{ width: "15em", height: "25em" }}>
				<div className="gradient" style={{ width: "100%" }}></div>
			</div>
			<h6 className="m-0 mt-1 px-1 gradient w-75"
				style={{
					width: "150px",
					whiteSpace: "nowrap",
					overflow: "hidden",
					textOverflow: "clip",
					color: "#232323"
				}}>
				video
			</h6>
			<h6 className="mt-1 mx-1 mb-2 px-1 py-0 gradient w-50" style={{ color: "#232323" }}>username</h6>
		</div>
	)
}

export default LoadingKaraokeMedia