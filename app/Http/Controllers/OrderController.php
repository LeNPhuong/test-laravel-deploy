<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function checkout(Request $request)
    {
        DB::beginTransaction(); // Bắt đầu transaction để đảm bảo dữ liệu nhất quán
        try {
            $cart = $request->cart;

            if (!$cart || count($cart) === 0) {
                return $this->sendError('Giỏ hàng trống!');
            }

            // Kiểm tra voucher (nếu có)
            $voucher = null;
            if ($request->voucher_id) {
                $voucher = Voucher::find($request->voucher_id);
                if (!$voucher || !$voucher->active || now()->lt($voucher->start_date) || now()->gt($voucher->end_date)) {
                    return $this->sendError('Voucher không hợp lệ hoặc đã hết hạn!', '', 400);
                }
            }

            // Lấy danh sách product_id từ giỏ hàng
            $productIds = array_column($cart, 'id');
            // Lấy tất cả sản phẩm một lần
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');


            // Kiểm tra xem có đơn hàng nào đang chờ thanh toán hay không
            $existingOrder = Order::where('user_id', auth()->user()->id)
                ->where('status_id', 1) // Status 1 có thể là 'đang chờ thanh toán'
                ->first();

            if ($existingOrder) {
                return $this->sendResponse($existingOrder, 'Bạn đã có một đơn hàng chưa hoàn thành. Bạn có thể thanh toán cho đơn hàng này.');
            }

            // Tính toán tổng số tiền
            $totalAmount = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));

            // Nếu có voucher hợp lệ, áp dụng chiết khấu
            if ($voucher) {
                $discount = 0;
                if ($voucher->discount_type === 'percentage') {
                    $discount = ($totalAmount * $voucher->discount_value) / 100;
                } else {
                    $discount = $voucher->discount_value;
                }
                $discount = min($discount, $voucher->max_discount_value); // Không vượt quá giá trị tối đa
                $totalAmount -= $discount; // Giảm tổng số tiền
            }

            // Tạo đơn hàng
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->voucher_id = $request->voucher_id ?? null; 
            $order->total_price = $totalAmount;
            $order->status_id = 1; // Trạng thái 'đang chờ thanh toán'
            $order->save();

            // Lưu từng sản phẩm vào bảng order_items
            foreach ($cart as $item) {
                $product = $products->get($item['id']);

                // Kiểm tra nếu sản phẩm tồn tại và số lượng có đủ không
                if ($product && $product->quantity >= $item['quantity']) {
                    // Giảm số lượng tồn kho
                    $product->quantity -= $item['quantity'];
                    $product->save();

                    // Xóa cache sau khi cập nhật
                    Cache::forget('active_products');

                    // Lưu chi tiết đơn hàng
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'unit' => $item['unit'],
                    ]);
                } else {
                    // Nếu sản phẩm không đủ hàng, rollback và trả về lỗi
                    DB::rollBack();
                    return $this->sendError("Sản phẩm {$product->name} không đủ hàng trong kho!", '', 400);
                }
            }

            DB::commit(); // Xác nhận transaction nếu không có lỗi xảy ra
            return $this->sendResponse($order, 'Đặt hàng thành công!');
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback nếu có lỗi xảy ra
            return $this->sendError('Lỗi định dạng.', ['error' => $th->getMessage()], 404);
        }
    }
}
