import Link from 'next/link'
import { useRouter } from 'next/router'
import onCartAudios from '@/functions/onCartAudios'

import Img from 'next/image'
import Btn from '../core/Btn'
import CartSVG from '../../svgs/CartSVG'

const AudioMedia = (props) => {

	const router = useRouter()

	// Buy function
	const onBuyAudios = (audio) => {
		onCartAudios(props, audio)
		setTimeout(() => router.push('/cart'), 500)
	}

	return (
		<div className="d-flex p-2">
			<div className="audio-thumbnail">
				<Link href={`/audio/${props.audio.id}`}>
					<a onClick={() => {
						props.audioStates.setShow({ id: props.audio.id, time: 0 })
						props.setLocalStorage("show", {
							"id": props.audio.id,
							"time": 0
						})
					}}>
						<Img src={props.audio.thumbnail} width="50px" height="50px" />
					</a>
				</Link>
			</div>
			<div className="p-2 me-auto">
				<span onClick={() => {
					props.audioStates.setShow({ id: props.audio.id, time: 0 })
					props.setLocalStorage("show", {
						"id": props.audio.id,
						"time": 0
					})
				}}>
					<h6 className="mb-0 pb-0 audio-text">
						{props.audio.name}
					</h6>
					<h6 className="mt-0 pt-0">
						<small>{props.audio.username}</small>
						<small className="ms-1">{props.audio.ft}</small>
					</h6>
				</span>
			</div>
			{!props.audio.hasBought && !props.hasBoughtAudio ?
				props.audio.inCart ?
					<div>
						<button
							className="btn text-light rounded-0 pt-1"
							style={{
								minWidth: '40px',
								height: '33px',
								backgroundColor: "#232323"
							}}
							onClick={() => onCartAudios(props, props.audio.id)}>
							<CartSVG />
						</button>
					</div> :
					<>
						<div>
							<button
								className="mysonar-btn white-btn"
								style={{ minWidth: '40px', height: '33px' }}
								onClick={() => onCartAudios(props, props.audio.id)}>
								<CartSVG />
							</button>
						</div>
						<div className="ms-2">
							<Btn
								btnClass="mysonar-btn green-btn btn-2 float-right"
								btnText="KES 10"
								onClick={() => onBuyAudios(props.audio.id)} />
						</div>
					</> : ""}
		</div>
	)
}

AudioMedia.defaultProps = {
	hasBoughtAudio: false
}

export default AudioMedia
