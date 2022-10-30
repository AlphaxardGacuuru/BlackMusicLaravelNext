<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilePondController extends Controller
{
    public function updateProfilePic(Request $request, $id)
    {
        /* Handle file upload */
        if ($request->hasFile('filepond-profile-pic')) {
            $pp = $request->file('filepond-profile-pic')->store('public/profile-pics');
            $pp = substr($pp, 7);

            $user = User::find($id);
            $user->pp = $pp;
            $user->save();

            // Delete profile pic if it's not the default one
            if ($user->pp != '/storage/profile-pics/male_avatar.png') {
                Storage::delete('public/' . $user->pp);
            }

            return response("Account updated", 200);
        }
    }
}
