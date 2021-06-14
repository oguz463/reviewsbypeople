<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded=[];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(static::class, 'parent_id');
    }
}
