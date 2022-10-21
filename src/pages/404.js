const NotFoundPage = () => {
	return (
		<div className="row">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				<div className="mt-5 p-5 rounded-0" style={{ backgroundColor: "#232323" }}>
					<center>
						<h1 className="mt-3">404</h1>
						<h2 className="mt-3">
							Sorry <svg xmlns="http://www.w3.org/2000/svg"
								width="1.2em"
								height="1.2em"
								fill="currentColor"
								className="bi bi-emoji-frown"
								viewBox="0 0 16 16">
								<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
								<path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
							</svg>
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
