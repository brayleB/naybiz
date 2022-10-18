<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tenants')->insert([
            'landlord_id' => '1',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'email' => 'jdelacruz@gmail.com',
            'contact_no' => '0123456789',
            'valid_id' => 'id',
            'address' => 'USA',
            'status' => 'new',
        ]);
    }
}