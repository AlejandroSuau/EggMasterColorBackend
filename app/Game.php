<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'win', 'score', 'combos_quantity', 'destroyed_enemies', 
        'second_when_lost', 'level_user_id'
    ];

    protected $appends = ['achieved_stars_seconds'];

    public function stars() {
        return $this->belongsToMany('App\Star', 'games_stars')->withTimestamps()->withPivot('obtained_second');
    }

    public function getAchievedStarsSecondsAttribute() {
        $seconds = array();
        foreach($this->stars()->get() as $star) {
            $seconds[] = $star->pivot->obtained_second;
        }
        return $seconds;
    }

    public function attachAchievedStarsSeconds($achievedStarsSeconds) {
        $starId = 1;
        foreach($achievedStarsSeconds as $achievedSecond) {
            $this->stars()->attach($starId, ['obtained_second' => $achievedSecond]);
            $starId ++;
        }
    }
}
