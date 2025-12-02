<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultPinSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPin = '1234';

        // Mettre le PIN hashé pour tous les utilisateurs
        User::query()->update([
            'stock_pin' => Hash::make($defaultPin)
        ]);

        echo "✔ Code PIN par défaut appliqué à tous les utilisateurs : {$defaultPin}\n";
    }
}
