<?php

namespace Database\Seeders;

use \App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'username' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
            'name' => 'Root',
            'family' => 'Superusers',
            'birth' => '2021-03-02',
            'gender' => 'male',
        ]);

        User::factory(100)->reader()->create();
    }
}
