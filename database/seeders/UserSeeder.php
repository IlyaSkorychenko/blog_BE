<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'username',
            'email' => 'email@example.com',
            'password' => 'password',
        ]);

        User::factory()
            ->count(5)
            ->create();

        User::all()->each(function ($user) {
            Profile::factory()
                ->for($user)
                ->create();
        });
    }
}
