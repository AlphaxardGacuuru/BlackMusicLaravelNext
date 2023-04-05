<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';

// Get Auth
Route::get('auth', [UserController::class, 'auth']);

// Mailables
Route::get('/mailable/welcome', function () {
    $user = App\Models\User::all()->random();

    $video = App\Models\Video::all()->random();

    return new App\Mail\WelcomeMail($user->username, $video);
});

Route::get('/mailable/audio-receipt', function () {
    $audios = App\Models\Audio::all();

    return new App\Mail\AudioReceiptMail($audios);
});

Route::get('/mailable/video-receipt', function () {
    $videos = App\Models\Video::all();

    return new App\Mail\VideoReceiptMail($videos);
});
