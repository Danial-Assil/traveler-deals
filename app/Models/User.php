<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'mobile',
        'mobile_verified_at',
        'email',
        'email_verified_at',
        'is_verified',
        'image',
        'first_name',
        'last_name',
        'place',
        'country',
        'city',
        'birthdate',
        'gender',
        'passport',
        'id_card',
        'photo_ID',
        'refer_code',
        'invitation_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'shopper_rating', 'passport_path', 'id_card_path', 'document_verified', 'traveler_rating', 'image_path'];
    public function getImagePathAttribute()
    {
        return $this->image ? asset('uploads/' . $this->table . '/' . $this->image) : asset('assets/dash/img/no-profile-img.png');
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getPassportPathAttribute()
    {
        return $this->passport ? route('storage.file', ['users', $this->id, $this->passport]) : null;
    }
    public function getIdCardPathAttribute()
    {
        return $this->id_card ? route('storage.file', ['users', $this->id, $this->id_card]) : null;
    }
    public function getDocumentVerifiedAttribute()
    {
        return $this->passport || $this->id_card  ? true : false;
    }
    public function getShopperRatingAttribute()
    {
        $id = $this->id;
        $review_ratings = ReviewRating::where('user_id', '!=', $id)->whereHas('deal.order', function ($q) use ($id) {
            $q->where('user_id',  $id);
        })->get();
        return $review_ratings->count() > 0 ? $review_ratings->sum('star_rating') / $review_ratings->count() : 0;
    }
    public function getTravelerRatingAttribute()
    {
        $id = $this->id;
        $review_ratings = ReviewRating::where('user_id', '!=', $id)->whereHas('deal.trip', function ($q) use ($id) {
            $q->where('user_id',  $id);
        })->get();
        return $review_ratings->count() > 0 ? $review_ratings->sum('star_rating') / $review_ratings->count() : 0;
    }
    public function getShopperRatingStars()
    {
        $val = '';
        for ($i = 0; $i < $this->shopper_rating; $i++) {
            $val .= '<i class="fa fa-star" style="color:gold"></i>';
        }
        for ($i = 0; $i < 5 - $this->shopper_rating; $i++) {
            $val .= '<i class="fa fa-star" style="color:#aaa"></i>';
        }
        return $val;
    }
    public function getTravelerRatingStars()
    {
        $val = '';
        for ($i = 0; $i < $this->traveler_rating; $i++) {
            $val .= '<i class="fa fa-star" style="color:gold"></i>';
        }
        for ($i = 0; $i < (5 - $this->traveler_rating); $i++) {
            $val .= '<i class="fa fa-star" style="color:#aaa"></i>';
        }
        return $val;
    }
    public function getStatusTxt()
    {
        return !$this->is_verified ? trans('users.not_verified') : ($this->status == 1 ? trans('users.active') : trans('users.unactive'));
    }
    public function getGenderTxt()
    {
        return $this->gender == 1 ? trans('dash.female') :  trans('dash.male');
    }

    public function custom_notifications()
    {
        $notifications = [];
        $user_notifications = $this->notifications;

        foreach ($user_notifications as $notif) {
            $notification['data'] = $notif->data;
            $notification['data']['title'] = trans($notif->data['title']);
            $notification['data']['body'] = trans($notif->data['body']);
            $notification['id'] = $notif->id;
            $notification['is_read'] = $notif->read_at ? true : false;
            array_push($notifications, $notification);
        }
        return $notifications;
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function my_reviews()
    {
        return $this->hasMany(ReviewRating::class);
    }
    public function recieved_reviews()
    {
        return $this->hasMany(ReviewRating::class, 'rated_id', 'id');
    }
    public function attachments()
    {
        return $this->hasMany(UserAttachment::class);
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function deals()
    {
        return $this->hasMany(Trip::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function fcms()
    {
        return $this->hasMany(UserFcm::class);
    }
    public function attachements()
    {
        return $this->hasMany(UserAttachment::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
