<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asin extends Model
{
    protected $guarded = [];

    protected $casts = [
       'data' => 'array'
  ];

    public function data()
    {
        return $this->morphTo();
    }
}
