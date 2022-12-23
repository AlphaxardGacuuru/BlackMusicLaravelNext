import axios from '@/lib/axios'

const onFollow = (props) => {
	// Function for following users
	// Change follow button
	const newUsers = props.users
		.filter((item) => {
			// Get the exact user and change follow button
			if (item.username == props.user.username) {
				item.hasFollowed = !item.hasFollowed
			}
			return true
		})
	// Set new Users
	props.setUsers(newUsers)

	// Add follow
	axios.post(`/api/follows`, { musician: props.user.username })
		.then((res) => {
			props.setMessages([res.data])
			// Update users
			props.get("users", props.setUsers, "users")
			// Update posts
			props.get("posts", props.setPosts, "posts")
		}).catch((err) => props.getErrors(err, true))
}

export default onFollow