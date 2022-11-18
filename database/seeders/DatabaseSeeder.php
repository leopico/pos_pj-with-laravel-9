<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Container\BoundMethod;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '09254717973',
            'gender' => 'male',
            'address' => 'Pyay',
            'role' => 'admin',
            'password' => Hash::make('Maco@1992'),
        ]);
    }
}
