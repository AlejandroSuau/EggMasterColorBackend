<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Game;
use App\User;
use App\LevelUser;

class GamesController extends Controller
{
    public function index() {
        $games = Game::All();
        return response()->json($games);
    }

    public function store(Request $request)  {
        try {
            $user = User::GetByProfileServiceId($request->profile_service_id)->firstOrFail();
            $levelUser = LevelUser::GetByLevelIdAndUserId($request->level_id, $user->id)->firstOrFail();
            $newGameValues = [
                'win' => $request->win,
                'score' => $request->score,
                'combos_quantity' => $request->combos_quantity,
                'destroyed_enemies' => $request->destroyed_enemies,
                'level_user_id' => $levelUser->id
            ];

            if (isset($request->second_when_lost)) {
                $newGameValues['second_when_lost'] = $request->second_when_lost;
            }

            $newGame = Game::create($newGameValues);

            if (isset($request->achieved_stars_seconds)) {
                $newGame->attachAchievedStarsSeconds($request->achieved_stars_seconds);
            }

            if ($newGame->win) {
                $newGame->unlocked_level_id = $this->unlockNextLevelToThis($levelUser->level_id, $user->id);
            } else {
                $newGame->unlocked_level_id = null;
            }

            return response()->json($newGame);
        } catch(\Exception $e) {
            $error = "Problems encountered. Cannont insert the game.";
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    private function unlockNextLevelToThis($levelId, $userId) {
        $nextLevelUser = LevelUser::GetNextLevelByLevelIdAndUserId($levelId, $userId)->firstOrFail();
        if (is_null($nextLevelUser) || !$nextLevelUser->is_lock) {
            $levelIdUnlocked = null;
        } else {
            $nextLevelUser->is_lock = false;
            $nextLevelUser->save();
            $levelIdUnlocked = $nextLevelUser->level_id;
        }
        return $levelIdUnlocked;
    }
}
