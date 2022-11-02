<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilePondController extends Controller
{
    /*
     * Handle Profile Pic Upload */
    public function updateProfilePic(Request $request, $id)
    {
        if ($request->hasFile('filepond-profile-pic')) {
            $pp = $request->file('filepond-profile-pic')->store('public/profile-pics');
            $pp = substr($pp, 7);

            $user = User::find($id);

            // Delete profile pic if it's not the default one
            if ($user->pp != '/storage/profile-pics/male_avatar.png') {
                Storage::delete('public/' . $user->pp);
            }

            $user->pp = $pp;
            $user->save();

            return response("Account updated", 200);
        }
    }

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
}
