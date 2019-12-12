<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    public function users() {
        return $this->belongsToMany('App\User', 'users_profile_types', 
            'profile_type_id', 'user_id')->withPivot('profile_service_id');
    }
}
