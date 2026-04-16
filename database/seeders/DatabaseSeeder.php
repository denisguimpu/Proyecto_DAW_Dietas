<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'denisalinalarisa@gmail.com'],
            [
                'name' => 'denis',
                'password' => '$2y$12$Zwgh3XZAPlTZUFDc5a7r1uz8hue4y4FNNWs5CAnFj9csrSn6t6pVa',
                'remember_token' => '0unDFJW21KttXtlPcdFSTgJT8XsAgOEFahmRucwHY8tpCOdTjXUt65n1I9sn',
                'email_verified_at' => null,
            ]
        );

        $this->call([
            IngredientSeeder::class,
        ]);
    }
}