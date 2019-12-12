<?php

use Illuminate\Database\Seeder;

use App\User;
use App\ProfileType;
use App\Star;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(StarSeeder::class);
        $this->call(LevelsSeeder::class);
        $this->call(EnemyTypesSeeder::class);
    }
}

class UsersSeeder extends Seeder
{
    public function run() {
        DB::table('users')->delete();
        DB::table('profile_types')->delete();

        $createdUser = User::create([
            'username' => 'Grommy',
            'enabled' => true
        ]);
        
        $createdProfile = ProfileType::create([
            'type' => 'Game Center'
        ]);

        $createdUser->profile_types()->attach($createdProfile->id, ['profile_service_id' => 'xxxIDGAMECENTERxxx']);
    }
}

class StarSeeder extends Seeder
{
    public function run() {
        DB::table('stars')->delete();
        Star::create(['name' => 'Star One']);
        Star::create(['name' => 'Star Two']);
        Star::create(['name' => 'Star Three']);
    }
}
