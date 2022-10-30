<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'phone',
        'gender',
        'account_type',
        'account_type_2',
        'pp',
        'pb',
        'bio',
        'dob',
        'location',
        'withdrawal',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function audios()
    {
        return $this->hasMany(Audio::class, 'username');
    }

    public function audioAlbums()
    {
        return $this->hasMany(AudioAlbum::class, 'username');
    }

    public function audioComments()
    {
        return $this->hasMany(AudioComment::class, 'username');
    }

    public function audioCommentLikes()
    {
        return $this->hasMany(AudioCommentLike::class, 'username');
    }

    public function audioLikes()
    {
        return $this->hasMany(AudioLike::class, 'username');
    }

    public function boughtAudios()
    {
        return $this->hasMany(AudioLike::class, 'username');
    }

    public function boughtVideos()
    {
        return $this->hasMany(AudioLike::class, 'username');
    }

    public function cartAudios()
    {
        return $this->hasMany(AudioLike::class, 'username');
    }

    public function cartVideos()
    {
        return $this->hasMany(AudioLike::class, 'username');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'username');
    }

    public function decos()
    {
        return $this->hasMany(Deco::class, 'username');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'username');
    }

    public function karaokes()
    {
        return $this->hasMany(Karaoke::class, 'username');
    }

    public function karaokeAudios()
    {
        return $this->hasMany(KaraokeAudio::class, 'username');
    }

    public function karaokeComment()
    {
        return $this->hasMany(KaraokeComment::class, 'username');
    }

    public function karaokeCommentLikes()
    {
        return $this->hasMany(KaraokeCommentLike::class, 'username');
    }

    public function karaokeLikes()
    {
        return $this->hasMany(KaraokeLike::class, 'username');
    }

    public function kopokopos()
    {
        return $this->hasMany(Kopokopo::class, 'username');
    }

    public function kopokopoRecipients()
    {
        return $this->hasMany(KopokopoRecipient::class, 'username');
    }

    public function polls()
    {
        return $this->hasMany(Poll::class, 'username');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'username');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class, 'username');
    }

    public function postCommentLikes()
    {
        return $this->hasMany(PostCommentLike::class, 'username');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class, 'username');
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'username');
    }

    public function savedKaraokes()
    {
        return $this->hasMany(SavedKaraoke::class, 'username');
    }

    public function searches()
    {
        return $this->hasMany(Search::class, 'username');
    }

    public function songPayouts()
    {
        return $this->hasMany(SongPayout::class, 'username');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'username');
    }

    public function videoAlbums()
    {
        return $this->hasMany(VideoAlbum::class, 'username');
    }

    public function videoComments()
    {
        return $this->hasMany(VideoComment::class, 'username');
    }

    public function videoCommentLikes()
    {
        return $this->hasMany(VideoCommentLike::class, 'username');
    }

    public function videoLikes()
    {
        return $this->hasMany(VideoLike::class, 'username');
    }
}
