<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'meta' => 'array'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class)->whereNotNull('published_at');
    }

    public function products()
    {
        return $this->hasMany(Product::class)->whereNotNull('published_at');
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->whereNotNull('published_at');
    }

    public function path()
    {
        return url('author', $this->id);
    }
}
