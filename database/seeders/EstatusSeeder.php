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
            ['nombre' => 'Aprobado Pendiente'],
            ['nombre' => 'Pagado'],
            ['nombre' => 'Cancelado'],
        ];

        DB::table('estatus')->insert($estatus);

    }
}
