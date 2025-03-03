<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'role' => 'doctor',
                'email' => "doctor$i@gmail.com",
            ]);
        }
        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'role' => 'patient',
                'email' => "patient$i@gmail.com",
            ]);
        }
    }
}
