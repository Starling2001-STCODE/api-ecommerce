<?php

namespace Database\Seeders;


use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // AttributeSeeder::class,
            // CategorySeeder::class,
            ProductSeeder::class,
        ]);
        
        // User::factory()->create([
        //     'name' => 'test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        //     'username' => 'test',
        //     'role' => 'director',
        // ]);
    }
}
