<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Chat
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Chat extends Model
{
    protected $hidden = [
        'pivot'
    ];

    public function messages()
    {
        return $this->hasMany('App\Message')->latest()->take(50)->with('user');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);//->where('user_id', '!=', Auth::id());
    }
}
