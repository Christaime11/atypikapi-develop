<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TypeHabitatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_habitats')->insert([
            'libelle'=>env('DEFAULT_TYPE_HABITAT'),
            'created_at'=>Carbon::now(),

        ]);
    }
}
