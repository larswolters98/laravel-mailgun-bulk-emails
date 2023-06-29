<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // We create a user with an allowed email address
        User::factory()->create([
            'name' => 'Lars Wolters',
            'email' => 'larstwolters@gmail.com',
        ]);

        // We create 1999 users with a random email address
        User::factory(1999)->create();
    }
}
