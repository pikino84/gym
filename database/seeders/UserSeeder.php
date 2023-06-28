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
            'name' => 'Super Admin',
            'email' => 'israelrivasgtz@gmail.com',
            'username' => 'superadmin',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => bcrypt('contraseña'),
        ]);

        $user->assignRole('Admin');

        $user = User::create([
            'name' => 'Productor Demo',
            'email' => 'pro@pro.com',
            'username' => 'productor',
            'password' => bcrypt('productor'),
        ]);

        $user->assignRole('Proveedor');
    }
}
