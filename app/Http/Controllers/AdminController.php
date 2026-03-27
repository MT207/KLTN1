<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\AdminLoginRequest;

class AdminController extends Controller
{
    public function index()
    {
        $id_chuc_nang = 1; // Assuming a specific ID for viewing admins, adjust if needed
        $login = Auth::guard('sanctum')->user();
        $id_chuc_vu = $login->id_chuc_vu;
        $check_quyen = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $data = Admin::all();
        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $id_chuc_nang = 2; // Assuming a specific ID for creating admins, adjust if needed
        $login = Auth::guard('sanctum')->user();
        $id_chuc_vu = $login->id_chuc_vu;
        $check_quyen = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $data = Admin::create([
            'id_chuc_vu' => $request->id_chuc_vu,
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_open' => $request->is_open ?? 1,
            'is_master' => $request->is_master ?? 0,
            'trang_thai' => $request->trang_thai ?? 1,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Thêm tài khoản admin ' . $data->ho_va_ten . ' thành công',
        ]);
    }

    public function update(Request $request)
    {
        $id_chuc_nang = 3; // Assuming a specific ID for updating admins, adjust if needed
        $login = Auth::guard('sanctum')->user();
        $id_chuc_vu = $login->id_chuc_vu;
        $check_quyen = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }

        $updateData = [
            'id_chuc_vu' => $request->id_chuc_vu,
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'is_open' => $request->is_open ?? 1,
            'is_master' => $request->is_master ?? 0,
            'trang_thai' => $request->trang_thai ?? 1,
        ];

        if ($request->has('password') && $request->password != '') {
            $updateData['password'] = Hash::make($request->password);
        }

        $data = Admin::where('id', $request->id)->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật tài khoản admin ' . $request->ho_va_ten . ' thành công',
        ]);
    }

    public function destroy(Request $request)
    {
        $id_chuc_nang = 4; // Assuming a specific ID for deleting admins, adjust if needed
        $login = Auth::guard('sanctum')->user();
        $id_chuc_vu = $login->id_chuc_vu;
        $check_quyen = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if (!$check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $data = Admin::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa tài khoản admin thành công',
        ]);
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Thông tin đăng nhập không chính xác.',
            ], 401);
        }

        if ($admin->trang_thai != 1) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản đã bị khóa.',
            ], 403);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công.',
            'data' => [
                'admin' => $admin,
                'token' => $token,
            ],
        ]);
    }
}
