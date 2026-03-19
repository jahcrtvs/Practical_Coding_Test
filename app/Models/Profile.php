<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'bio',
    ];

    /**
     * Define the relationship to the user who owns this profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
