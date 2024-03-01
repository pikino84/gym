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
            'email' => 'pikino84@gmail.com',
            'username' => 'superadmin',
            'password' => bcrypt('chetoS47@'),
        ]);

        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'ebutron@printec.com.mx',
            'username' => 'admin',
            'password' => bcrypt('lalo123'),
        ]);

        $user->assignRole('Admin');

    }
}
