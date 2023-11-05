<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estatus = [
            ['nombre' => 'Pendiente'],
            ['nombre' => 'Válido'],
            ['nombre' => 'En proceso de pago'],
            ['nombre' => 'Pagado'],
        ];

        DB::table('estatus')->insert($estatus);

    }
}
