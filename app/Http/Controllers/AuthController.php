<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:6',
                'regex:/[a-zA-Z]/', // ít nhất một chữ cái
                'regex:/[0-9]/', // ít nhất một số
                'regex:/[^a-zA-Z0-9]/', // ít nhất một ký tự đặc biệt
            ],
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Lỗi định dạng', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['user'] = $user;
        return $this->sendResponse($success, 'Đăng ký tài khoản thành công.');
    }
    public function login()
    {
        $credentials = request(['email', 'password']);
        // Kiểm tra xác thực
        if (!$token = auth()->attempt($credentials)) {
            return $this->sendError('Không được chấp nhận', ['error' => 'Unathorized'], 401);
        }
        // Trả về token
        $success = $this->respondWithToken($token);

        return $this->sendResponse($success, 'Đăng nhập thành công');
    }
    public function refresh()
    {
        $success = $this->respondWithToken(auth()->refresh());
        return $this->sendResponse($success, 'Đã refresh thông tin tài khoản');
    }
    public function logout()
    {
        auth()->logout();
        return $this->sendResponse('','Đăng xuất thành công');
    }
    public function profile()
    {
        // Lấy người dùng hiện tại
        $user = auth()->user();
        // Chọn chỉ những trường cần thiết
        $success = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
        ];

        return $this->sendResponse($success, 'Vào hồ sơ tài khoản thành công');
    }
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // thời gian sống của token
        ];
    }
}
