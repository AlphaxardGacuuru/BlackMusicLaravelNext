import React, { useState, Suspense } from "react"
import { useRouter } from "next/router"
import Link from "next/link"
import axios from "@/lib/axios"

import Img from "next/image"
import Btn from "../../components/Core/Btn"
import LoadingVideoMedia from "../../components/Video/LoadingVideoMedia"
import LoadingAudioMedia from "../../components/Audio/LoadingAudioMedia"

import CheckSVG from "../../svgs/CheckSVG"
import DecoSVG from "../../svgs/DecoSVG"
import LoadingPostMedia from "../../components/Post/LoadingPostMedia"
import PostMedia from "../../components/Post/PostMedia"
import PostOptions from "../../components/Post/PostOptions"

const VideoMedia = React.lazy(() => import("../../components/Video/VideoMedia"))
const AudioMedia = React.lazy(() => import("../../components/Audio/AudioMedia"))

const Profile = props => {
    const router = useRouter()

    let { username } = router.query

    const [tabClass, setTabClass] = useState("videos")
    const [bottomMenu, setBottomMenu] = useState("")
    const [userToUnfollow, setUserToUnfollow] = useState()
    const [postToEdit, setPostToEdit] = useState()
    const [editLink, setEditLink] = useState()
    const [deleteLink, setDeleteLink] = useState()
    const [unfollowLink, setUnfollowLink] = useState()

    // Get Profile info
    if (props.users.find(user => user.username == username)) {
        var profile = props.users.find(user => user.username == username)
    } else {
        var profile = []
    }

    // Function for buying video to cart
    const onBuyVideos = video => {
        props.onCartVideos(video)
        setTimeout(() => router.push("/cart"), 1000)
    }

    // Function for buying audio to cart
    const onBuyAudios = audio => {
        props.onCartAudios(audio)
        setTimeout(() => router.push("/cart"), 1000)
    }

    // Function for deleting posts
    const onDeletePost = id => {
        axios
            .delete(`${props.url}/api/posts/${id}`)
            .then(res => {
                props.setMessages([res.data])
                // Update posts
                props.get("posts", props.setPosts, "posts")
            })
            .catch(err => props.getErrors(err, true))
    }

    return (
        <>
            <div
                className="row p-0 m-0"
                style={{
                    backgroundImage: `url('${profile.backdrop}')`,
                    backgroundPosition: "center",
                    backgroundSize: "cover",
                    position: "relative",
                    height: "100%",
                }}>
                <div className="col-sm-12 p-0">
                    <br />
                    <br className="hidden" />
                    <div>
                        <div
                            className="avatar-container"
                            style={{
                                marginTop: "100px",
                                top: "70px",
                                left: "10px",
                            }}>
                            {props.users
                                .filter(user => user.username == username)
                                .map((profile, key) => (
                                    <Img
                                        key={key}
                                        style={{
                                            position: "absolute",
                                            zIndex: "99",
                                        }}
                                        className="avatar hover-img"
                                        src={profile.avatar}
                                        layout="fill"
                                    />
                                ))}
                        </div>
                    </div>
                </div>
            </div>
            {/* <!-- End of Profile pic area --> */}

            {/* {{-- Profile Area --}} */}
            <div className="row border-bottom border-dark">
                <div className="col-sm-1"></div>
                <div className="col-sm-10">
                    <br />
                    <br />
                    <br className="anti-hidden" />
                    {/* Check whether user has bought at least one song from musician */}
                    {/* Check whether user has followed musician and display appropriate Btn */}
                    {profile.username == props.auth?.username ? (
                        <Link href="/profile/edit">
                            <a>
                                <Btn
                                    btnClass="mysonar-btn white-btn float-end"
                                    btnText="edit profile"
                                />
                            </a>
                        </Link>
                    ) : profile.username != "@blackmusic" ? (
                        profile.hasFollowed ? (
                            <Btn
                                className={"btn btn-light float-end rounded-0"}
                                onClick={() => props.onFollow(username)}>
                                Followed
                                <CheckSVG />
                            </Btn>
                        ) : profile.hasBought1 ? (
                            <Btn
                                btnClass="mysonar-btn white-btn float-end"
                                onClick={() => props.onFollow(username)}
                                btnText="follow"
                            />
                        ) : (
                            <Btn
                                btnClass="mysonar-btn white-btn float-end"
                                onClick={() =>
                                    props.setErrors([
                                        `You must have bought atleast one song by ${username}`,
                                    ])
                                }
                                btnText="follow"
                            />
                        )
                    ) : (
                        ""
                    )}
                    <div>
                        <h3>{profile.name}</h3>
                        <h5>
                            {profile.username}
                            <span style={{ color: "gold" }} className="ms-2">
                                <DecoSVG />
                                <small className="ms-1">{profile.decos}</small>
                            </span>
                        </h5>
                        <h6>{profile.bio}</h6>
                    </div>
                    <div className="d-flex flex-row">
                        <div className="p-2">
                            <span>Following</span>
                            <br />
                            <span>{profile.following}</span>
                        </div>
                        <div className="p-2">
                            <span>Fans</span>
                            <br />
                            <span>{profile.fans}</span>
                        </div>
                    </div>
                </div>
                <div className="col-sm-1"></div>
            </div>
            {/* {{-- End of Profile Area --}} */}

            {/* Tabs for Videos, Posts and Audios */}
            <div className="d-flex">
                <div className="p-2 flex-fill anti-hidden">
                    <h4
                        className={
                            tabClass == "videos" ? "active-scrollmenu" : "p-1"
                        }
                        onClick={() => setTabClass("videos")}>
                        <center>Videos</center>
                    </h4>
                </div>
                <div className="p-2 flex-fill anti-hidden">
                    <h4
                        className={
                            tabClass == "posts" ? "active-scrollmenu" : "p-1"
                        }
                        onClick={() => setTabClass("posts")}>
                        <center>Posts</center>
                    </h4>
                </div>
                <div className="p-2 flex-fill anti-hidden">
                    <h4
                        className={
                            tabClass == "audios" ? "active-scrollmenu" : "p-1"
                        }
                        onClick={() => setTabClass("audios")}>
                        <center>Audios</center>
                    </h4>
                </div>
            </div>
            {/* Tabs for Videos, Posts and Audios End */}

            <div className="row">
                <div className="col-sm-1"></div>
                <div
                    className={
                        tabClass == "videos" ? "col-sm-3" : "col-sm-3 hidden"
                    }>
                    <center className="hidden">
                        <h4>Videos</h4>
                    </center>
                    {props.videoAlbums.filter(
                        videoAlbum => videoAlbum.username == username,
                    ).length == 0 && (
                        <center className="mt-3">
                            <h6 style={{ color: "grey" }}>
                                {username} does not have any videos
                            </h6>
                        </center>
                    )}

                    {/* Video Albums */}
                    {props.videoAlbums
                        .filter(videoAlbum => videoAlbum.username == username)
                        .map((videoAlbum, key) => (
                            <div key={videoAlbum.id} className="mb-5">
                                <div className="d-flex">
                                    <div className="p-2">
                                        <Img
                                            src={videoAlbum.cover}
                                            width="100px"
                                            height="100px"
                                            alt="album cover"
                                        />
                                    </div>
                                    <div className="p-2">
                                        <small>Video Album</small>
                                        <h1>{videoAlbum.name}</h1>
                                        <h6>{videoAlbum.created_at}</h6>
                                    </div>
                                </div>
                                {props.videos
                                    .filter(
                                        video =>
                                            video.videoAlbumId == videoAlbum.id,
                                    )
                                    .map((video, index) => (
                                        <Suspense
                                            key={video.id}
                                            fallback={<LoadingVideoMedia />}>
                                            <VideoMedia
                                                {...props}
                                                video={video}
                                                onBuyVideos={onBuyVideos}
                                            />
                                        </Suspense>
                                    ))}
                            </div>
                        ))}
                    {/* Videos Albums End */}
                </div>

                <div
                    className={
                        tabClass == "posts" ? "col-sm-4" : "col-sm-4 hidden"
                    }>
                    <center className="hidden">
                        <h4>Posts</h4>
                    </center>
                    {props.posts.filter(post => post.username == username)
                        .length == 0 && (
                        <center>
                            <h6 style={{ color: "grey" }}>
                                {username} does not have any posts
                            </h6>
                        </center>
                    )}

                    {/* <!-- Posts area --> */}
                    {props.posts
                        .filter(post => post.username == username)
                        .filter(
                            post =>
                                post.hasFollowed ||
                                props.auth?.username == "@blackmusic",
                        )
                        .map((post, key) => (
                            <Suspense key={key} fallback={<LoadingPostMedia />}>
                                <PostMedia
                                    {...props}
                                    post={post}
                                    setBottomMenu={setBottomMenu}
                                    setUserToUnfollow={setUserToUnfollow}
                                    setPostToEdit={setPostToEdit}
                                    setEditLink={setEditLink}
                                    setDeleteLink={setDeleteLink}
                                    onDeletePost={onDeletePost}
                                    setUnfollowLink={setUnfollowLink}
                                />
                            </Suspense>
                        ))}
                </div>
                {/* <!-- Posts area end --> */}
                <div
                    className={
                        tabClass == "audios" ? "col-sm-3" : "col-sm-3 hidden"
                    }>
                    <center className="hidden">
                        <h4>Audios</h4>
                    </center>
                    {props.audioAlbums.filter(
                        audioAlbum => audioAlbum.username == username,
                    ).length == 0 && (
                        <center className="mt-3">
                            <h6 style={{ color: "grey" }}>
                                {username} does not have any audios
                            </h6>
                        </center>
                    )}

                    {/* Audio Albums */}
                    {props.audioAlbums
                        .filter(audioAlbum => audioAlbum.username == username)
                        .map((audioAlbum, key) => (
                            <div key={audioAlbum.id} className="mb-5">
                                <div className="d-flex">
                                    <div className="p-2">
                                        <Img
                                            src={audioAlbum.cover}
                                            width="100px"
                                            height="100px"
                                            alt={"album cover"}
                                        />
                                    </div>
                                    <div className="p-2">
                                        <small>Audio Album</small>
                                        <h1>{audioAlbum.name}</h1>
                                        <h6>{audioAlbum.created_at}</h6>
                                    </div>
                                </div>
                                {props.audios
                                    .filter(
                                        audio =>
                                            audio.audioAlbumId == audioAlbum.id,
                                    )
                                    .map((audio, key) => (
                                        <Suspense
                                            key={audio.id}
                                            fallback={<LoadingAudioMedia />}>
                                            <AudioMedia
                                                {...props}
                                                audio={audio}
                                                onBuyAudios={onBuyAudios}
                                            />
                                        </Suspense>
                                    ))}
                            </div>
                        ))}
                    {/* Audio Albums End */}
                </div>
                <div className="col-sm-1"></div>
            </div>

            {/* Sliding Bottom Nav */}
            <PostOptions
                {...props}
                bottomMenu={bottomMenu}
                setBottomMenu={setBottomMenu}
                unfollowLink={unfollowLink}
                userToUnfollow={userToUnfollow}
                editLink={editLink}
                postToEdit={postToEdit}
                deleteLink={deleteLink}
                onDeletePost={onDeletePost}
            />
            {/* Sliding Bottom Nav end */}
        </>
    )
}

export default Profile
