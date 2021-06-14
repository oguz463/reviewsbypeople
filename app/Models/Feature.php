<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function featurable()
    {
        return $this->morphTo();
    }
}
