<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Level;
use App\LevelUser;
use App\Tile;

class LevelsSeeder extends Seeder 
{
    public function run() {
        DB::table('levels')->delete();
        DB::table('tiles')->delete();
        
        $user = User::find(1);
        $levels = $this->testLevels();

        $colNumber = 7;
        $rowNumber = 6;
        for($rowIndex = 0; $rowIndex < $rowNumber; $rowIndex ++) {
            for($columnIndex = 0; $columnIndex < $colNumber; $columnIndex++) {
                $tile = Tile::create([
                    'column_index' => $columnIndex,
                    'row_index' => $rowIndex
                ]);

                foreach($levels as $level) {
                    $level->tiles()->attach($tile->id, ['contain_enemy' => rand(0,1)]);
                }
            }
        }

        $i = 0;
        foreach($levels as $level) {
            if ($i == 0) {
                $isLock = false;
            } else {
                $isLock = true;
            }
            // Attaching minimum score stars to level
            $level->score_stars()->attach(1, ['minimum_score' => 250]);
            $level->score_stars()->attach(2, ['minimum_score' => 450]);
            $level->score_stars()->attach(3, ['minimum_score' => 500]);
            
            // Attaching level to user
            $levelUser = LevelUser::create([
                'level_id' => $level->id,
                'user_id' => $user->id,
                'is_lock' => $isLock
            ]);
            $i ++;
        }
    }

    private function testLevels() {
        return [
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 20,
                'player_frequency_to_change_color' => 3.3,
                'colors_quantity' => 2,
                'enabled' => true
            ]),
            Level::create([
                'starting_seconds' => 15,
                'player_frequency_to_change_color' => 3.5,
                'colors_quantity' => 2,
                'enabled' => true
            ])
        ];
    }
}