<?php

namespace Database\Seeders;

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
        $user=User::create([
            'firstname' => "prenom",
            'lastname' => "nom",
            'username' => "username",
            'email' => "mail@mail.com",
            'password' => bcrypt("password"),
            ]);
            $user->save();
    }
}
