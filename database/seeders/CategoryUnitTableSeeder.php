<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now(); // Lấy thời gian hiện tại

        $relations = [
            ['category_id' => 1, 'unit_id' => 1, 'created_at' => $now, 'updated_at' => $now], // Rau củ với kg
            ['category_id' => 1, 'unit_id' => 2, 'created_at' => $now, 'updated_at' => $now], // Rau củ với thùng

            ['category_id' => 2, 'unit_id' => 3, 'created_at' => $now, 'updated_at' => $now], // Gia vị với chai
            ['category_id' => 2, 'unit_id' => 1, 'created_at' => $now, 'updated_at' => $now], // Gia vị với kg
            ['category_id' => 2, 'unit_id' => 6, 'created_at' => $now, 'updated_at' => $now], // Gia vị với gam

            ['category_id' => 3, 'unit_id' => 1, 'created_at' => $now, 'updated_at' => $now], // Gạo bột với kg
            ['category_id' => 3, 'unit_id' => 2, 'created_at' => $now, 'updated_at' => $now], // Gạo bột với thùng

            ['category_id' => 4, 'unit_id' => 5, 'created_at' => $now, 'updated_at' => $now], // Sữa với lít
            ['category_id' => 4, 'unit_id' => 3, 'created_at' => $now, 'updated_at' => $now], // Sữa với chai

            ['category_id' => 5, 'unit_id' => 4, 'created_at' => $now, 'updated_at' => $now], // Bánh kẹo với cái
            ['category_id' => 5, 'unit_id' => 1, 'created_at' => $now, 'updated_at' => $now], // Bánh kẹo với kg
            ['category_id' => 5, 'unit_id' => 6, 'created_at' => $now, 'updated_at' => $now], // Bánh kẹo với gam

            ['category_id' => 6, 'unit_id' => 1, 'created_at' => $now, 'updated_at' => $now], // Mì miến với kg
            ['category_id' => 6, 'unit_id' => 6, 'created_at' => $now, 'updated_at' => $now], // Mì miến với gam

            ['category_id' => 7, 'unit_id' => 4, 'created_at' => $now, 'updated_at' => $now], // Đồ dùng với cái

            ['category_id' => 8, 'unit_id' => 5, 'created_at' => $now, 'updated_at' => $now], // Nước uống với lít
            ['category_id' => 8, 'unit_id' => 3, 'created_at' => $now, 'updated_at' => $now], // Nước uống với chai
        ];

        DB::table('category_unit')->insert($relations);
    }
}
