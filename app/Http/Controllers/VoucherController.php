<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Carbon\Carbon;

class VoucherController extends BaseController
{
    public function getVoucher()
    {
        try {

            // Lấy thời gian hiện tại   
            $currentDate = Carbon::now();
            // Lấy các voucher hợp lệ:
            // - Trạng thái phải là 'active'
            // - Ngày hiện tại nằm trong khoảng 'start_date' và 'end_date'
            $vouchers = Voucher::where('active', 1)
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->get();
            if ($vouchers->isEmpty()) {
                return $this->sendError('Không có voucher nào hợp lệ!', '', 400);
            }
            return $this->sendResponse($vouchers, 'Lấy danh sách voucher thành công!');
        } catch (\Throwable $th) {
            return $this->sendError('Đã có lỗi xảy ra.', ['error' => $th->getMessage()], 404);
        }
    }
}
