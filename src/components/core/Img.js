import Image from 'next/image'

const Img = ({ src, width, height, imgClass, style, alt }) => {
	return (
		<Image
			src={src}
			width={width}
			height={height}
			className={imgClass}
			style={style}
			alt={alt}
			loading="lazy" />
	)
}

Img.defaultProps = {
	src: '/storage/img/musical-note.png',
	alt: 'image',
}

export default Img