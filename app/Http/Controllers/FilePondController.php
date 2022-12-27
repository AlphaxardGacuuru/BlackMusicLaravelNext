<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilePondController extends Controller
{
    /*
     * Handle Profile Pic Upload */
    public function updateProfilePic(Request $request, $id)
    {
        if ($request->hasFile('filepond-profile-pic')) {
            $avatar = $request->file('filepond-profile-pic')->store('public/profile-pics');
            $avatar = substr($avatar, 7);

            $user = User::find($id);

            // Delete profile pic if it's not the default one
            if ($user->avatar != '/storage/profile-pics/male_avatar.png') {
                Storage::delete('public/' . $user->avatar);
            }

            $user->avatar = $avatar;
            $user->save();

            return response("Account updated", 200);
        }
    }

    /*
     *
     * Handle Video Uploads
     *
     */

    /*
     * Handle Video Thumbnail Upload */
    public function uploadVideoThumbnail(Request $request)
    {
        /* Handle thumbnail upload */
        $thumbnail = $request->file('filepond-thumbnail')->store('public/video-thumbnails');
        $thumbnail = substr($thumbnail, 7);
        return $thumbnail;
    }

    /*
     * Handle Video Upload */
    public function uploadVideo(Request $request)
    {
        /* Handle video upload */
        $video = $request->file('filepond-video')->store('public/videos');
        $videoShort = substr($video, 7);
        // $videoName = substr($video, 14);
        // $videoName = substr($videoName, 0, strpos($videoName, "."));

        // Create frame from Video
        // FFMpeg::open($video)
        //     ->getFrameFromSeconds(5)
        //     ->export()
        //     ->save('public/video-thumbnails/' . $videoName . '.png');

        return $videoShort;
    }

    /*
     * Update VideoThumbnail */
    public function updateVideoThumbnail(Request $request, $id)
    {
        /* Handle thumbnail upload */
        $thumbnail = $request->file('filepond-thumbnail')->store('public/video-thumbnails');
        $thumbnail = substr($thumbnail, 7);

        $video = Video::find($id);

        // Delete thumbnail
        $oldThumbnail = $video->thumbnail;
        Storage::delete('public/' . $oldThumbnail);

        // Update Thumbnail
        $video->thumbnail = $thumbnail;
        $video->save();
    }

    /*
     * Update VideoThumbnail */
    public function updateVideo(Request $request, $id)
    {
        /* Handle thumbnail upload */
        $videoFile = $request->file('filepond-video')->store('public/videos');
        $videoFile = substr($videoFile, 7);

        $video = Video::find($id);

        // Delete thumbnail
        $oldvideoFile = $video->video;
        Storage::delete('public/' . $oldvideoFile);

        // Update Thumbnail
        $video->video = $videoFile;
        $video->save();
    }

    /*
     * Handle Video Thumbnail Delete */
    public function deleteVideoThumbnail($id)
    {
        Storage::delete('public/video-thumbnails/' . $id);
        return response("Video thumbnail deleted", 200);
    }

    /*
     * Handle Video Delete */
    public function deleteVideo($id)
    {
        Storage::delete('public/videos/' . $id);
        return response("Video deleted", 200);
    }

    /*
     *
     * Handle Audio Uploads
     *
     */

    /*
     * Handle Audio Thumbnail Upload */
    public function uploadAudioThumbnail(Request $request)
    {
        /* Handle thumbnail upload */
        $thumbnail = $request->file('filepond-thumbnail')->store('public/audio-thumbnails');
        $thumbnail = substr($thumbnail, 7);
        return $thumbnail;
    }

    /*
     * Handle Audio Upload */
    public function uploadAudio(Request $request)
    {
        /* Handle audio upload */
        $audio = $request->file('filepond-audio')->store('public/audios');
        $audioShort = substr($audio, 7);
        // $audioName = substr($audio, 14);
        // $audioName = substr($audioName, 0, strpos($audioName, "."));

        // Create frame from Audio
        // FFMpeg::open($audio)
        //     ->getFrameFromSeconds(5)
        //     ->export()
        //     ->save('public/audio-thumbnails/' . $audioName . '.png');

        return $audioShort;
    }

    /*
     * Update AudioThumbnail */
    public function updateAudioThumbnail(Request $request, $id)
    {
        /* Handle thumbnail upload */
        $thumbnail = $request->file('filepond-thumbnail')->store('public/audio-thumbnails');
        $thumbnail = substr($thumbnail, 7);

        $audio = Audio::find($id);

        // Delete thumbnail
        $oldThumbnail = $audio->thumbnail;
        Storage::delete('public/' . $oldThumbnail);

        // Update Thumbnail
        $audio->thumbnail = $thumbnail;
        $audio->save();
    }

    /*
     * Update AudioThumbnail */
    public function updateAudio(Request $request, $id)
    {
        /* Handle thumbnail upload */
        $audioFile = $request->file('filepond-audio')->store('public/audios');
        $audioFile = substr($audioFile, 7);

        $audio = Audio::find($id);

        // Delete thumbnail
        $oldaudioFile = $audio->audio;
        Storage::delete('public/' . $oldaudioFile);

        // Update Thumbnail
        $audio->audio = $audioFile;
        $audio->save();
    }

    /*
     * Handle Audio Thumbnail Delete */
    public function deleteAudioThumbnail($id)
    {
        Storage::delete('public/audio-thumbnails/' . $id);
        return response("Audio thumbnail deleted", 200);
    }

    /*
     * Handle Audio Delete */
    public function deleteAudio($id)
    {
        Storage::delete('public/audios/' . $id);
        return response("Audio deleted", 200);
    }

    /*
     *
     * Handle Post Uploads
     *
     */

    public function uploadFileMedia(Request $request)
    {
        /* Handle media upload */
        $media = $request->file('filepond-media')->store('public/post-media');
        $media = substr($media, 7);
        return $media;
    }
}
