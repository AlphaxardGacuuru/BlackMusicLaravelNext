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
use App\Http\Controllers\EmailController;
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
use App\Http\Controllers\PushController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SavedKaraokeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SMSController;
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

// Auth::routes();

// Social logins
Route::get('login/{website}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{website}/callback', 'Auth\LoginController@handleProviderCallback');

// Update on Login Route
Route::post('login/update', 'Auth\LoginController@update');

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
    'chat' => ChatController::class,
    'decos' => DecoController::class,
    'email' => EmailController::class,
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
    'push' => PushController::class,
    'referrals' => ReferralController::class,
    'saved-karaokes' => SavedKaraokeController::class,
    'search' => SearchController::class,
    'song-payouts' => SongPayoutController::class,
    'sms' => SMSController::class,
    'users' => UserController::class,
    'videos' => VideoController::class,
    'video-likes' => VideoLikeController::class,
    'video-comments' => VideoCommentController::class,
    'video-comment-likes' => VideoCommentLikeController::class,
    'video-albums' => VideoAlbumController::class,
]);

// Authenticated User
Route::get('auth', [UserController::class, 'auth']);

Route::get('video-charts', [VideoController::class, 'charts']);
Route::get('audio-charts', [AudioController::class, 'charts']);


Route::get('mailable', function () {

    $amount = 100;
    $phone = '0700364446';

    return new App\Mail\SongPayout($amount, $phone);
});
