<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'column_index', 'row_index'
    ];

    public function levels() {
        return $this->belongsToMany('App\Level', 'levels_tiles', 
            'tile_id', 'level_id')->withPivot('contain_enemy');
    }

    public static function rowAndColumnMaxDimensions() {
        $dimensions = new \stdClass();
        $dimensions->rowsQuantity = Tile::max('row_index') + 1;
        $dimensions->columnsQuantity = Tile::max('column_index') + 1;
        return $dimensions;
    }
}
