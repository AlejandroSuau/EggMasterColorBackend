<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnemyType extends Model
{
    protected $fillable = [
        'type', 'value', 'score'
    ];
}
