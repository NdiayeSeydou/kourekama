<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'kourekama',
            'email' => 'kourekama@gmail.com',
            'password' => Hash::make('kourekama123'), // change le mot de passe après
           
        ]);
    }
}
