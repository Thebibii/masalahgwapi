<?php

namespace Database\Seeders;

use App\Http\Helpers\AnonymousGenerator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for ($i = 0; $i < 50; $i++) {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'common']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'anonymous' => AnonymousGenerator::generateUniqueCode(),
            'id_role' => 1
        ]);
        // }
    }
}
