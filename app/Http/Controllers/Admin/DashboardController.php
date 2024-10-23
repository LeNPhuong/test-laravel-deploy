<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Exception;

class DashboardController extends BaseController
{
    public function index() {
        try {
            // Khởi tạo mảng để chứa tất cả các dữ liệu
            $dashboardData = [];

            // Tổng số đơn hàng
            $totalOrders = Order::count();
            $dashboardData['total_orders'] = $totalOrders;

            // Tổng doanh thu từ các đơn hàng đã giao (status id = 4)
            $totalRevenue = Order::where('status_id', 4)->sum('total_price');
            $dashboardData['total_revenue'] = $totalRevenue;

            // Tổng sản phẩm đã bán
            $totalProductsSold = OrderDetail::sum('quantity');
            $dashboardData['total_products_sold'] = $totalProductsSold;

            // Thành viên mới trong tuần
            $newMembers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                              ->count();
            $dashboardData['new_members'] = $newMembers;

            // Sản phẩm hot trong tuần (Sản phẩm bán chạy nhất)
            $hotProducts = Product::select('product.*')
                                ->join('order_detail', 'product.id', '=', 'order_detail.product_id')
                                ->whereBetween('order_detail.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->groupBy('product.id')
                                ->orderByRaw('SUM(order_detail.quantity) DESC')
                                ->limit(5)
                                ->get();
            $dashboardData['hot_products'] = $hotProducts;

            // Doanh thu tuần (chỉ tính đơn hàng đã giao, status id = 4)
            $weeklyRevenue = Order::where('status_id', 4)
                                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->sum('total_price');
            $dashboardData['weekly_revenue'] = $weeklyRevenue;

            // Trả về tất cả dữ liệu trong một lần
            return $this->sendResponse($dashboardData, 'Truy xuất dữ liệu dashboard thành công.');

        } catch (Exception $th) {
            // Trả về lỗi nếu xảy ra
            return $this->sendError('Lỗi định dạng.', ['error' => $th->getMessage()], 500);
        }
    }
}
