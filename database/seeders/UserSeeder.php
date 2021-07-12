<?php

namespace Database\Seeders;

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
        //
        User::factory(200)->create();
        $users = User::all();
        $roles = ['buyer', 'merchant'];
        foreach ($users as $user) {
            $user->assignRole($roles[array_rand($roles)]);
            $user->save();
        }
    }
}
