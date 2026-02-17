<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Jozef Mrkva',
            'email' => 'jozef.mrkva@example.com',
        ]);

        Todo::factory()->count(25)->create([
            'user_id' => $user->id,
        ]);
    }
}
