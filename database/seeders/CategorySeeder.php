<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('categories')->insert([
            ['name' => 'KHUYẾN MÃI', 'key' => 'khuyen-mai', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'RAU CỦ', 'key' => 'rau-cu', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'GIA VỊ', 'key' => 'gia-vi', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'GAO BỘT', 'key' => 'gao-bot', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'SỮA', 'key' => 'sua', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'BÁNH KẸO', 'key' => 'banh-keo', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'MÌ MIẾN', 'key' => 'mi-mien', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ĐỒ DÙNG', 'key' => 'do-dung', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'NƯỚC UỐNG', 'key' => 'nuoc-uong', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
