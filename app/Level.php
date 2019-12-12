<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        "starting_seconds", "player_frequency_to_change_color", "colors_quantity", "enable"
    ];
    
    protected $hidden = [
        'score_stars', 'pivot'
    ];

    protected $appends = [
        'tiles', 'min_score_for_stars'
    ];

    public function tiles() {
        return $this->belongsToMany('App\Tile', 'levels_tiles', 
            'level_id', 'tile_id')->withPivot('contain_enemy');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'levels_users',
            'level_id', 'user_id')->withPivot('is_lock'); 
    }

    public function score_stars() {
        return $this->belongsToMany('App\Star', 'levels_stars', 
            'level_id', 'star_id')->withPivot('minimum_score');
    }

    public function enemy_types() {
        return $this->belongsToMany('App\EnemyType', 'levels_enemy_types',
            'level_id', 'enemy_type_id')->withTimestamps()->withPivot('probability');
    }

    public function getEnabledTextAttribute() {
        return $this->enabled ? 'Yes' : 'No';
    } 

    public function getPlayersPlayingQuantityAttribute() {
        return count($this->users);
    }

    public function scopeEnableds($query) {
        return $query->where('enabled', 1);
    }

    public function orderedTiles() {
        return $this->tiles()
            ->orderBy('row_index', 'asc')
            ->orderBy('column_index', 'asc');
    }

    public function getTilesAttribute() {
        return $this->formatTilesByLevel();
    }

    public function scopeGetNextLevelEnabled($query, $currentId) {
        return $this->enables()->where('id', '>', $currentId)->limit(1);
    }

    private function formatTilesByLevel() {
        $tiles = array();
        foreach($this->orderedTiles()->get() as $tile) {
            $tiles[$tile->row_index][$tile->column_index] = $tile->pivot->contain_enemy;
        }
        return $tiles;
    }

    public function formatEnemyTypesByLevel() {
        $enemyTypes = array();
        foreach($this->enemy_types as $enemyType) {
            $enemyObject = new \stdClass();
            $enemyObject->type = $enemyType->type;
            $enemyObject->value = $enemyType->value;
            $enemyObject->score = $enemyType->score;
            $enemyObject->probability = $enemyType->pivot->probability;

            $enemyTypes[] = $enemyObject;
        }
        return $enemyTypes;
    }

    public function getMinScoreForStarsAttribute() {
        return $this->formatMinScoreForStarsByLevel();
    }

    private function formatMinScoreForStarsByLevel() {
        $stars = array();
        foreach($this->score_stars as $scoreStar) {
            $stars[] = $scoreStar->pivot->minimum_score;
        }
        return $stars;
    }
}
