<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username', 'enabled'
    ];

    protected $appends = [
        'levels'
    ];

    public function profile_types() {
        return $this->belongsToMany('App\ProfileType', 'users_profile_types',
            'user_id', 'profile_type_id')->withPivot('profile_service_id');
    }

    public function levels_users() {
        return $this->hasMany('App\LevelUser');
    }

    public function getLevelsAttribute() {
        $levels = array();
        foreach($this->levels_users()->get() as $levelUser) {
            $levels[] = $levelUser->getJsonFormat();
        }
        return $levels;
    }

    public function scopeGetByProfileServiceId($query, $profileServiceId) {
        $user = $query->whereHas('profile_types', function($query) use ($profileServiceId) {
            $query->where('profile_service_id', $profileServiceId);
        });
        return $user;
    }
}
