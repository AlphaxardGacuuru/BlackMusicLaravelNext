import { useEffect } from 'react'
import { useRouter } from 'next/router'
import axios from '@/lib/axios'

import Karaoke from '@/components/Karaoke/Karaoke'

const KaraokeShow = (props) => {

	const router = useRouter()

	const { id } = router.query

	useEffect(() => {
		// Scroll Karaoke to current one
		var karaokeEl = document.getElementById(id)

		karaokeEl && karaokeEl.scrollIntoView();
	}, [])

	return (
		<div className="row p-0">
			<div className="col-sm-4"></div>
			<div className="col-sm-4">
				<div className="karaokes">
					{props.karaokes
						.map((karaoke, key) => (
							<Karaoke
								{...props}
								id={karaoke.id}
								key={key}
								karaoke={karaoke}
								karaokes={props.karaokes}
								setKaraokes={props.setKaraokes} />
						))}
				</div>
			</div>
			<div className="col-sm-4"></div>
		</div>
	)
}

export default KaraokeShow