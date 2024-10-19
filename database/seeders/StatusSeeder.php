<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['text_status' => 'Chưa thanh toán'],
            ['text_status' => 'Đang xử lý'],
            ['text_status' => 'Đang giao'],
            ['text_status' => 'Đã giao'],
            ['text_status' => 'Đã hủy'],
            ['text_status' => 'Trả hàng'],
        ];

        DB::table('status')->insert($statuses);
    }
}
