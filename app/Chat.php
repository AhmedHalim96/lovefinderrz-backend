<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $hidden = [
        'pivot'
    ];

    public function messages()
    {
        return $this->hasMany('App\Message')->latest();
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
