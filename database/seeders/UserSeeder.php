<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Fancisco',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Admin');

        $user = User::create([
            'name' => 'Proveedor Test',
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => bcrypt('test'),
        ]);

        $user->assignRole('Admin');
    }
}
