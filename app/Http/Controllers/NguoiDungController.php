<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class NguoiDungController extends Controller
{
    public function index()
    {
        $data = NguoiDung::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = NguoiDung::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = NguoiDung::where('id', $request->id)->first();
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
        $data = NguoiDung::where('id', $request->id)->first();
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
        $query = NguoiDung::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ho_va_ten', 'like', '%' . $keyword . '%');
                $q->orWhere('email', 'like', '%' . $keyword . '%');
                $q->orWhere('so_dien_thoai', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = NguoiDung::where('id', $request->id)->first();
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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không đúng'
            ], 401);
        }

        if (!$user->trang_thai) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản đã bị khóa'
            ], 403);
        }

        // Tạo token sử dụng Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }
    public function logout(Request $request)
    {
        // Xóa tất cả token của người dùng hiện tại
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Đăng xuất thành công'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email' => 'required|email|unique:nguoi_dungs,email',
            'password' => 'required|string|min:8',
            're_password' => 'required|string|min:8',
            'id_chuc_vu' => 'nullable|exists:chuc_vus,id',
            'id_doi_tac' => 'nullable|exists:doi_tacs,id',
        ]);

        if ($request->password !== $request->re_password) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu nhập lại không khớp!'
            ], 400);
        }

        $user = NguoiDung::create([
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'id_chuc_vu' => $request->id_chuc_vu,
            'id_doi_tac' => $request->id_doi_tac,
            'trang_thai' => true, // Mặc định active
        ]);

        // Tạo token ngay sau khi đăng ký
        $token = $user->createToken('token_nguoi_dung')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng ký thành công',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }

    public function xacThucKhuonMat(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'id' => 'required',
            'du_lieu_khuon_mat' => 'required'
        ]);

        // Giải mã Vector mới từ Frontend gửi lên (mảng 128 số)
        $vector_moi = json_decode($request->du_lieu_khuon_mat);

        // 2. KIỂM TRA TRÙNG LẶP: Quét toàn bộ DB xem mặt này có ai xài chưa
        // Lấy tất cả user đã có FaceID, ngoại trừ chính người đang quét
        $danh_sach_khac = NguoiDung::whereNotNull('du_lieu_khuon_mat')
            ->where('id', '!=', $request->id)
            ->get();

        foreach ($danh_sach_khac as $user_khac) {
            $vector_cu = json_decode($user_khac->du_lieu_khuon_mat);

            // Tính khoảng cách giữa mặt mới và mặt trong DB
            $khoang_cach = $this->tinhToanDistance($vector_moi, $vector_cu);

            // Nếu khoảng cách < 0.6 => Hai mặt này là một người
            if ($khoang_cach < 0.6) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi! Khuôn mặt này đã được đăng ký'
                ], 400); // Trả về lỗi 400 để FE bắt được
            }
        }

        // 3. Nếu không trùng thì tiến hành lưu cho User hiện tại
        $nguoi_dung = NguoiDung::find($request->id);

        if ($nguoi_dung) {
            $nguoi_dung->du_lieu_khuon_mat = $request->du_lieu_khuon_mat;
            $nguoi_dung->save();

            return response()->json([
                'success' => true,
                'message' => 'Xác thực khuôn mặt thành công!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Người dùng không tồn tại'
        ], 404);
    }

    /**
     * Hàm tính khoảng cách Euclid giữa 2 vector 128 chiều
     */
    private function tinhToanDistance($vectorA, $vectorB)
    {
        // Kiểm tra nếu một trong hai vector bị rỗng hoặc không phải mảng
        if (!is_array($vectorA) || !is_array($vectorB)) {
            return 1.0; // Trả về khoảng cách lớn (không khớp) để an toàn
        }

        if (count($vectorA) !== count($vectorB) || count($vectorA) === 0) {
            return 1.0;
        }

        $sum = 0;
        for ($i = 0; $i < count($vectorA); $i++) {
            $sum += pow($vectorA[$i] - $vectorB[$i], 2);
        }
        return sqrt($sum);
    }
}
