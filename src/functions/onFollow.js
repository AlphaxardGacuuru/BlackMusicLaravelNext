import axios from "@/lib/axios"

const onFollow = (props) => {
	// Add follow
	axios
		.post(`/api/follows`, { musician: props.user.username })
		.then((res) => {
			props.setMessages([res.data])
			// Update users
			props.users && props.get("users", props.setUsers, "users")
			// Update posts
			props.posts && props.get("posts", props.setPosts, "posts")
		})
		.catch((err) => props.getErrors(err, true))
}

export default onFollow
