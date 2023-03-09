<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AudioAlbumController;
use App\Http\Controllers\AudioCommentController;
use App\Http\Controllers\AudioCommentLikeController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\AudioLikeController;
use App\Http\Controllers\BoughtAudioController;
use App\Http\Controllers\BoughtVideoController;
use App\Http\Controllers\CartAudioController;
use App\Http\Controllers\CartVideoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DecoController;
use App\Http\Controllers\FilePondController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\KaraokeAudioController;
use App\Http\Controllers\KaraokeCommentController;
use App\Http\Controllers\KaraokeCommentLikeController;
use App\Http\Controllers\KaraokeController;
use App\Http\Controllers\KaraokeLikeController;
use App\Http\Controllers\KopokopoController;
use App\Http\Controllers\KopokopoRecipientController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostCommentLikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SavedKaraokeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SongPayoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoAlbumController;
use App\Http\Controllers\VideoCommentController;
use App\Http\Controllers\VideoCommentLikeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoLikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
	// Authenticated User
    Route::get('auth', [UserController::class, 'auth']);
});

// Route::middleware(['auth:sanctum'])->group(function () {
Route::apiResources([
    'admin' => AdminController::class,
    'audios' => AudioController::class,
    'audio-likes' => AudioLikeController::class,
    'audio-comments' => AudioCommentController::class,
    'audio-comment-likes' => AudioCommentLikeController::class,
    'audio-albums' => AudioAlbumController::class,
    'bought-audios' => BoughtAudioController::class,
    'bought-videos' => BoughtVideoController::class,
    'cart-audios' => CartAudioController::class,
    'cart-videos' => CartVideoController::class,
    'chats' => ChatController::class,
    'decos' => DecoController::class,
    'follows' => FollowController::class,
    'karaokes' => KaraokeController::class,
    'karaoke-comments' => KaraokeCommentController::class,
    'karaoke-comment-likes' => KaraokeCommentLikeController::class,
    'karaoke-likes' => KaraokeLikeController::class,
    'karaoke-audios' => KaraokeAudioController::class,
    'kopokopo' => KopokopoController::class,
    'kopokopo-recipients' => KopokopoRecipientController::class,
    'notifications' => NotificationController::class,
    'posts' => PostController::class,
    'post-likes' => PostLikeController::class,
    'post-comments' => PostCommentController::class,
    'post-comment-likes' => PostCommentLikeController::class,
    'polls' => PollController::class,
    'referrals' => ReferralController::class,
    'saved-karaokes' => SavedKaraokeController::class,
    'search' => SearchController::class,
    'song-payouts' => SongPayoutController::class,
    'users' => UserController::class,
    'videos' => VideoController::class,
    'video-likes' => VideoLikeController::class,
    'video-comments' => VideoCommentController::class,
    'video-comment-likes' => VideoCommentLikeController::class,
    'video-albums' => VideoAlbumController::class,
]);
// });

Route::get('video-charts', [VideoController::class, 'charts']);
Route::get('videos/download', [VideoController::class, 'download']);
Route::get('audio-charts', [AudioController::class, 'charts']);
Route::get('audios/download', [AudioController::class, 'download']);

// Filepond Controller
Route::prefix('filepond')->group(function () {
    Route::controller(FilePondController::class)->group(function () {
        Route::post('avatar/{id}', 'updateAvatar');
        // Video
        Route::post('video-thumbnail', 'storeVideoThumbnail');
        Route::post('video-thumbnail/{id}', 'updateVideoThumbnail');
        Route::post('video', 'storeVideo');
        Route::post('video/{id}', 'updateVideo');
        Route::delete('video-thumbnail/{id}', 'destoryVideoThumbnail');
        Route::delete('video/{id}', 'destoryVideo');

        // Audio
        Route::post('audio-thumbnail', 'storeAudioThumbnail');
        Route::post('audio-thumbnail/{id}', 'updateAudioThumbnail');
        Route::post('audio', 'storeAudio');
        Route::post('audio/{id}', 'updateAudio');
        Route::delete('audio-thumbnail/{id}', 'destoryAudioThumbnail');
        Route::delete('audio/{id}', 'destoryAudio');
		
		// Post
        Route::post('posts', 'storePostMedia');
        Route::delete('posts/{id}', 'destroyPostMedia');
    });
});

// Kopokopo STK Push
Route::post('stk-push', [KopokopoController::class, 'stkPush']);