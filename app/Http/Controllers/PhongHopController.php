<?php

namespace App\Http\Controllers;

use App\Models\PhongHop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

class PhongHopController extends Controller
{
    public function index()
    {
        $data = PhongHop::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // 1. Kiểm tra dữ liệu gửi lên
        $request->validate([
            'ten_phong'       => 'required|string|max:255',
            'id_chu_phong'    => 'required|integer',
            'so_nguoi_toi_da' => 'nullable|integer|min:2',
        ]);

        // 2. Tự động sinh ma_phong duy nhất (VD: xya-qwer-zxc)
        do {
            $ma_phong = strtolower(Str::random(3) . '-' . Str::random(4) . '-' . Str::random(3));
        } while (PhongHop::where('ma_phong', $ma_phong)->exists());

        // 3. Lưu vào Database
        $phongHop = PhongHop::create([
            'id_chu_phong'       => $request->id_chu_phong,
            'ma_phong'           => $ma_phong,
            'ten_phong'          => $request->ten_phong,
            'so_nguoi_toi_da'    => $request->so_nguoi_toi_da ?? 100, // Mặc định 100 người nếu không nhập
            'thoi_gian_bat_dau'  => $request->thoi_gian_bat_dau ?? now(),
            'thoi_gian_ket_thuc' => $request->thoi_gian_ket_thuc,
            'trang_thai'         => 1, // 1: Đang hoạt động
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Tạo phòng họp thành công!',
            'data'    => $phongHop
        ]);
    }

    public function update(Request $request)
    {
        $data = PhongHop::where('id', $request->id)->first();
        if ($data) {
            $data->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function destroy(Request $request)
    {
        $data = PhongHop::where('id', $request->id)->first();
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa thành công'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function search(Request $request)
    {
        $query = PhongHop::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ten_phong', 'like', '%' . $keyword . '%');
                $q->orWhere('ma_phong', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getByMaPhong($maPhong)
    {
        $data = PhongHop::where('ma_phong', $maPhong)->first();
        if ($data) {
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy phòng họp với mã: ' . $maPhong
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = PhongHop::where('id', $request->id)->first();
        if ($data) {
            $data->trang_thai = !$data->trang_thai;
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Đã thay đổi trạng thái thành công'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }
    public function taoToken(Request $request)
    {
        // 1. Kiểm tra xem Frontend có gửi đủ mã phòng và tên người dùng không
        $request->validate([
            'ma_phong' => 'required|string',
            'user_name' => 'required|string'
        ]);

        // 2. Lấy thông tin bảo mật từ file .env
        $apiKey = env('LIVEKIT_API_KEY');
        $apiSecret = env('LIVEKIT_API_SECRET');

        if (!$apiKey || !$apiSecret) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa cấu hình thẻ LIVEKIT_API_KEY trong file .env'
            ], 500);
        }

        // 3. Chuẩn bị "Hành trang" (Payload) cho cái vé vào cửa theo chuẩn LiveKit
        $payload = [
            'iss' => $apiKey,                   // Ai phát hành vé? (Là bạn)
            'sub' => $request->user_name,       // Vé này cấp cho ai? (ID hoặc Tên)
            'nbf' => time(),                    // Có hiệu lực từ lúc nào? (Ngay bây giờ)
            'exp' => time() + (60 * 60 * 2),    // Hết hạn khi nào? (Cho phép họp tối đa 2 tiếng)
            'video' => [
                'roomJoin' => true,             // Quyền: Được phép vào phòng
                'room' => $request->ma_phong,   // Cụ thể là phòng nào?
            ],
            'name' => $request->user_name,      // Tên hiển thị trong phòng họp
        ];

        try {
            // 4. "Đóng dấu" vé bằng thuật toán HS256 và Secret Key
            $token = JWT::encode($payload, $apiSecret, 'HS256');

            return response()->json([
                'status' => true,
                'message' => 'Cấp quyền vào phòng thành công!',
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi tạo Token: ' . $e->getMessage()
            ], 500);
        }
    }
}
