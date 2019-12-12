<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Level;
use App\Star;
use App\Tile;
use App\EnemyType;

class LevelsController extends Controller
{
    public function index($levelId = 0) {
        $levels = Level::All();

        if ($levelId > 0) {
            $infoMessage = "[Processed correctly, level ID: $levelId]";
        } else {
            $infoMessage = "";
        }

        return view('levels.list', compact(['levels', 'infoMessage']));
    }

    public function form($levelId = null) {
        $tiles = Tile::All();
        $stars = Star::All();
        $enemyTypes = EnemyType::All();
        $tileDimensions = Tile::rowAndColumnMaxDimensions();
        $compact = ['tiles', 'stars', 'tileDimensions', 'enemyTypes'];

        if ($levelId != null) {
            try {
                $level = Level::FindOrFail($levelId);
                $stars = $level->score_stars;
                $tiles = $level->tiles()->get();
                $enemyTypes = $level->enemy_types()->get();
                $compact[] = 'level';
            } catch (\Exception $e) { dd($e); }
        }

        return view('levels.form', compact($compact));
    }

    public function store(Request $request) {
        try {
            $newLevel = Level::create([
                'starting_seconds' => $request->starting_seconds,
                'player_frequency_to_change_color' => $request->player_frequency_to_change_color,
                'colors_quantity' => $request->colors_quantity,
                'enabled' => $request->enabled
            ]);

            $newLevel->score_stars()->sync($request->minimum_scores);
            $newLevel->tiles()->sync($request->tiles);
            $newLevel->enemy_types()->sync($request->probabilities);
            
            return $this->index($newLevel->id);
        } catch( \Exception $e) {
            dd("Failed on creation level.", $e);
        }
    }

    public function update(Request $request) {
        try {
            $level = Level::findOrFail($request->level_id);
            $level->starting_seconds = $request->starting_seconds;
            $level->player_frequency_to_change_color = $request->player_frequency_to_change_color;
            $level->colors_quantity = $request->colors_quantity;
            $level->enabled = $request->enabled;
            $level->save();

            $level->score_stars()->sync($request->minimum_scores);
            $level->tiles()->sync($request->tiles);
            $level->enemy_types()->sync($request->probabilities);

            return $this->index($level->id);
        } catch(\Exception $e) {
            dd("Failed on updating.", $e);
        }
    }

    public function show(Request $request) {
        try {
            $level = Level::enableds()->findOrFail($request->levelId);
            return response()->json($level);
        } catch (\Exception $e){
            dd('Select failed', $e);
        }
    }
}
