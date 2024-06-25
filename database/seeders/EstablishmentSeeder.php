<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Establishment;
use Illuminate\Database\Seeder;

class EstablishmentSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Establishment::create(
            [
                'name' => 'NextTech Avignon',
                'phone_number'=> '0490815450',
                'adress'=> '60 Chem. de Fontanille',
                'postal_code'=> '84140',
                'city'=> 'Avignon',
            ]
        );

        Establishment::create(
            [
                'name' => 'NextTech Pertuis',
                'phone_number'=> '0490770594',
                'adress'=> '180 Rue Philippe de Girard',
                'postal_code'=> '84120',
                'city'=> 'Pertuis',
            ]
        );
    }
}
