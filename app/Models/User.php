<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name',
        'email',
        'password',
    ];*/
    protected $fillable = [
        'username',
        'phone',
        'email',
        'password',
        'role',
        'wallet_balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin() {
        if ($this->role == 0) {
            return true;
        }
        return false;
    }

    public function isCustomer()
    {
        if ($this->role == 1) {
            return true;
        }
        return false;
    }

    public function comments() {
        return $this->hasMany(Comment::class, "user_id");
    }

    public function isCommentable($isbn) {
        return $this->hasManyThrough(Checkoutitems::class, Checkout::class, "user_id", "checkoutID")->where("status", "delivered")->where("book_isbn_no", $isbn)->get()->count() == 1;
    }
}
