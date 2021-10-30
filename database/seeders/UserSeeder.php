<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

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
            'username'=>'admin',
            'email'=>'admin@admin.com',
            'name' => 'Administrator',
            'password' => bcrypt('123456'),
            'status' => 'A',
        ]);
    }
}
