<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
           'name'=>env('ADMIN_NAME'),
           'email'=>env('ADMIN_EMAIL'),
           'password'=>Hash::make(env('ADMIN_PASS')),
           'telephone'=>env('ADMIN_TEL'),
           'adresse'=>env('ADMIN_ADRESSE'),
           'role'=>env('ADMIN_ROLE'),
           'created_at'=>Carbon::now(),
       ]);
    }
}
