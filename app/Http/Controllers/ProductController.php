<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm với thông tin danh mục
        // $products = Product::with('category')->where('active', 1)->get();

        $products = Cache::remember('active_products', 60, function () {
            return Product::with(['category' => function ($query) {
                $query->where('active', 1); // Lấy danh mục có active = 1
            }, 'category.units' => function ($query) {
                $query->where('active', 1); // Lấy đơn vị có active = 1
            }])
                ->select('id', 'cate_id', 'name', 'price', 'sale', 'img', 'type', 'description', 'made', 'active')
                ->get();
        });


        return response()->json($products);
    }
    public function show($id)
    {
        // Sử dụng cache để lưu trữ chi tiết sản phẩm
        $productDetail = Cache::remember("product_detail_{$id}", 60, function () use ($id) {
            return Product::with(['category' => function ($query) {
                $query->where('active', 1); // Lấy danh mục có active = 1
            }, 'category.units' => function ($query) {
                $query->where('active', 1); // Lấy đơn vị có active = 1
            }])
                ->select('id', 'cate_id', 'name', 'price', 'sale', 'img', 'type', 'description', 'made', 'active')
                ->find($id); // Tìm sản phẩm theo ID
        });

        // Kiểm tra nếu sản phẩm tồn tại
        if (!$productDetail) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        return response()->json($productDetail);
    }
}
