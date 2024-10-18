<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function checkout(Request $request)
    {
        try {
            $cart = $request->cart;

            if (!$cart || count($cart) === 0) {
                return $this->sendError('Giỏ hàng trống!');
            }
            // Kiểm tra voucher (nếu có)
            $voucher = null;
            if ($request->voucher_id) {
                $voucher = Voucher::find($request->voucher_id);
                if (!$voucher || !$voucher->is_active) {
                    return $this->sendError('Voucher không hợp lệ hoặc đã hết hạn!', '', 400);
                }
            }
            // Tạo đơn hàng
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->voucher_id = $request->voucher_id ?? null;
            $order->total_amount = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));
            $order->status_id = 1;
            $order->save();
            // Lưu từng sản phẩm vào bảng order_items
            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'unit' => $item['unit'],
                ]);
            }

            return $this->sendResponse($order, 'Đặt hàng thành công!');
        } catch (\Throwable $th) {
            return $this->sendError('Lỗi định dạng.', ['error' => $th->getMessage()], 404);
        }
    }
}
