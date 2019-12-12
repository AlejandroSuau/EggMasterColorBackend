<?php

use Illuminate\Database\Seeder;

use App\EnemyType;
use App\Level;

class EnemyTypesSeeder extends Seeder
{
    public function run() {
        DB::table('enemy_types')->delete();
        $basicEnemy = EnemyType::create([
            'type' => 'Basic',
            'value' => 1,
            'score' => 10
        ]);
        $armoredEnemy = EnemyType::create([
            'type' => 'Armored',
            'value' => 2,
            'score' => 20
        ]);
        $allChangerEnemy = EnemyType::create([
            'type' => 'Allchanger',
            'value' => 3,
            'score' => 40
        ]);
        $spineEnemy = EnemyType::create([
            'type' => 'Spine',
            'value' => 4,
            'score' => 40
        ]);

        $levels = Level::All();
        foreach($levels as $level) {
            $level->enemy_types()->attach($basicEnemy->id, ['probability' => 70]);
            $level->enemy_types()->attach($armoredEnemy->id, ['probability' => 5]);
            $level->enemy_types()->attach($allChangerEnemy->id, ['probability' => 5]);
            $level->enemy_types()->attach($spineEnemy->id, ['probability' => 20]);
        }
    }
}
