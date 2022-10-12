const LoadingVideoMedia = () => {
	return (
		<span className="mx-2 pt-0 px-0 pb-2">
			<div className="thumbnail">
				<div
					className="gradient"
					style={{
						width: "160em",
						height: "90em"
					}}>
				</div>
			</div>
			<div className="d-flex">
				<div className="p-1">
					<div
						className="gradient rounded-circle"
						style={{
							width: "3em",
							height: "3em"
						}}>
					</div>
				</div>
				<div className="p-1 flex-grow-1">
					<h6 className="loading-text gradient w-75"
						style={{ width: "150px", color: "#232323" }}>
						video
					</h6>
					<h6
						className="loading-text gradient w-50"
						style={{ color: "#232323" }}>
						username
					</h6>
				</div>
			</div>
			<div className="d-flex justify-content-between">
				<div className="p-1">
					<button
						className="gradient btn mb-1 rounded-pill float-start"
						style={{ minWidth: '90px', height: '33px', backgroundColor: "#232323" }}>
					</button>
				</div>
				<div className="p-1">
					<button
						className="gradient btn mb-1 rounded-pill float-end"
						style={{ minWidth: '90px', height: '33px', backgroundColor: "#232323" }}>
					</button>
				</div>
			</div>
		</span>
	)
}

export default LoadingVideoMedia