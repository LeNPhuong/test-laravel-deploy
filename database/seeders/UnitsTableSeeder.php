<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'kg', 'active' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'thùng', 'active' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'chai', 'active' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'cái', 'active' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'lít', 'active' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'gam', 'active' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('units')->insert($units);
    }
}
