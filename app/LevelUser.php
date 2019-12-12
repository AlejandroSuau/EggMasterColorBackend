<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    protected $table = 'levels_users';
    protected $fillable = [
        'level_id', 'user_id', 'is_lock'
    ];

    protected $appends = ['best_score', 'best_achieved_stars'];

    public function level() {
        return $this->belongsTo('App\Level');
    }

    public function games() {
        return $this->hasMany('App\Game');
    }

    public function wonGames() {
        return $this->games()->where('win', true);
    }

    public function scopeGetByLevelIdAndUserId($query, $levelId, $userId) {
        return $query->where('level_id', $levelId)->where('user_id', $userId);
    }

    public function scopeGetNextLevelByLevelIdAndUserId($query, $levelId, $userId) {
        return $query->where('level_id', '>', $levelId)->where('user_id', $userId)->limit(1);
    }

    public function getBestScoreAttribute() {
        try {
            $bestScore = $this->wonGames()->max('score');
        } catch(\Exception $e) {
            $bestScore = null;
        }
        return $bestScore;
    }

    public function getBestAchievedStarsAttribute() {
        $dbRows = \DB::select("SELECT MAX(obtained_second) as obtained_second, star_id"
        . " FROM games g"
        . " INNER JOIN games_stars gs ON g.id = gs.game_id"
        . " WHERE level_user_id = " . $this->id . " AND win = 1"
        . " GROUP BY star_id");

        $bestStars = array();
        foreach($dbRows as $row) {
            $bestStars[] = $row->obtained_second;
        }

        return $bestStars;
    }

    public function getJsonFormat() {
        $level = new \stdClass();
        
        $level->id = $this->level_id;
        $level->is_lock = $this->is_lock;
        $level->best_score = $this->best_score;
        $level->starting_seconds = $this->level->starting_seconds;
        $level->player_frequency_to_change_color = $this->level->player_frequency_to_change_color;
        $level->colors_quantity = $this->level->colors_quantity;
        $level->tiles = $this->level->tiles;
        $level->min_score_for_stars = $this->level->min_score_for_stars;
        $level->achieved_stars_second = $this->best_achieved_stars;
        $level->enemy_types = $this->level->formatEnemyTypesByLevel();

        return $level;
    }
}
