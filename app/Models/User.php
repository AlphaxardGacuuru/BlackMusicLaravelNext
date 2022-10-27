<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use App\Models\Deco;

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
        return $this->hasMany(Audio::class);
    }

    public function audioAlbums()
    {
        return $this->hasMany(AudioAlbum::class);
    }

    public function audioComments()
    {
        return $this->hasMany(AudioComment::class);
    }

    public function audioCommentLikes()
    {
        return $this->hasMany(AudioCommentLike::class);
    }

    public function audioLikes()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function boughtAudios()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function boughtVideos()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function cartAudios()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function cartVideos()
    {
        return $this->hasMany(AudioLike::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function decos()
    {
        return $this->hasMany(Deco::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function karaokes()
    {
        return $this->hasMany(Karaoke::class);
    }

    public function karaokeAudios()
    {
        return $this->hasMany(KaraokeAudio::class);
    }

    public function karaokeComment()
    {
        return $this->hasMany(KaraokeComment::class);
    }

    public function karaokeCommentLikes()
    {
        return $this->hasMany(KaraokeCommentLike::class);
    }

    public function karaokeLikes()
    {
        return $this->hasMany(KaraokeLike::class);
    }

    public function kopokopos()
    {
        return $this->hasMany(Kopokopo::class);
    }

    public function kopokopoRecipients()
    {
        return $this->hasMany(KopokopoRecipient::class);
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function postCommentLikes()
    {
        return $this->hasMany(PostCommentLike::class);
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function savedKaraokes()
    {
        return $this->hasMany(SavedKaraoke::class);
    }

    public function searches()
    {
        return $this->hasMany(Search::class);
    }

    public function songPayouts()
    {
        return $this->hasMany(SongPayout::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function videoAlbums()
    {
        return $this->hasMany(VideoAlbum::class);
    }

    public function videoComments()
    {
        return $this->hasMany(VideoComment::class);
    }

    public function videoCommentLikes()
    {
        return $this->hasMany(VideoCommentLike::class);
    }

    public function videoLikes()
    {
        return $this->hasMany(VideoLike::class);
    }
}
