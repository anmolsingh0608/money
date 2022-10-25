<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@fitmoney.com',
            'password' => bcrypt('762@duck!'),
            'role_type' => 'admin',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'certified' => 'no'
        ]);
    }
}
