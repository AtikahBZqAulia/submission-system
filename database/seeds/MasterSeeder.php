<?php

use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('identity_types')->insert([
            [
                'name'          => 'PASPOR',
                'description'   => 'Paspor'
            ],
            [
                'name'          => 'NIDN',
                'description'   => 'Nomor Induk Dosen Nasional'
            ],
            [
                'name'          => 'NIM',
                'description'   => 'Nomor Induk Mahasiswa'
            ],
            [
                'name'          => 'NO SIM',
                'description'   => 'Nomor SIM'
            ]
        ]);

        DB::table('pricing_types')->insert([
            [
                'name'          => 'Workshop',
                'description'   => 'Workshop only'
            ],
            [
                'name'          => 'Speakers',
                'description'   => 'Speakers only'
            ],
            [
                'name'          => 'Seminar',
                'description'   => 'Seminar only'
            ],
            [
                'name'          => 'Full',
                'description'   => 'Speakers, Workshop & Seminar '
            ]
        ]);

        DB::table('workstate_types')->insert([
            [
                'name'          => 'Submissions',
                'description'   => 'Submission State'
            ],
            [
                'name'          => 'Payments',
                'description'   => 'Payment state'
            ]
        ]);
    }
}
