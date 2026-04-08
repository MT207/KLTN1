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

        // 2. GIẢI MÃ BẢO MẬT: Thêm tham số 'true' để ép kiểu chắc chắn ra Array (mảng chuẩn) thay vì Object.
        // Hỗ trợ luôn trường hợp Frontend/Axios tự động ép thành mảng trước khi gửi.
        $vector_moi = is_string($request->du_lieu_khuon_mat)
            ? json_decode($request->du_lieu_khuon_mat, true)
            : $request->du_lieu_khuon_mat;

        if (!is_array($vector_moi)) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi định dạng dữ liệu sinh trắc học.'
            ], 400);
        }

        // 3. KIỂM TRA TRÙNG LẶP (1:N Matching)
        $danh_sach_khac = NguoiDung::whereNotNull('du_lieu_khuon_mat')
            ->where('id', '!=', $request->id)
            ->get();

        foreach ($danh_sach_khac as $user_khac) {
            $vector_cu = is_string($user_khac->du_lieu_khuon_mat)
                ? json_decode($user_khac->du_lieu_khuon_mat, true)
                : $user_khac->du_lieu_khuon_mat;

            $khoang_cach = $this->tinhToanDistance($vector_moi, $vector_cu);

            // 4. TINH CHỈNH THRESHOLD:
            // Hạ ngưỡng từ 0.6 xuống 0.5 để siết chặt bảo mật. (Nhỏ hơn 0.5 chắc chắn là 1 người).
            // Tránh việc 2 người khác nhau bị nhận diện nhầm (False Positive).
            if ($khoang_cach < 0.50) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi bảo mật! Sinh trắc học này đã được liên kết với một tài khoản khác trong hệ thống.'
                ], 400);
            }
        }

        // 5. LƯU DỮ LIỆU
        $nguoi_dung = NguoiDung::find($request->id);

        if ($nguoi_dung) {
            // Đảm bảo lưu vào DB dưới dạng chuỗi JSON nguyên bản
            $nguoi_dung->du_lieu_khuon_mat = is_array($request->du_lieu_khuon_mat)
                ? json_encode($request->du_lieu_khuon_mat)
                : $request->du_lieu_khuon_mat;

            $nguoi_dung->save();

            return response()->json([
                'success' => true,
                'message' => 'Đăng ký Face ID thành công!'
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
        // Ràng buộc chặt chẽ đầu vào
        if (!is_array($vectorA) || !is_array($vectorB) || count($vectorA) === 0 || count($vectorA) !== count($vectorB)) {
            return 1.0;
        }

        $sum = 0;
        for ($i = 0; $i < count($vectorA); $i++) {
            // Ép kiểu float để toán học chính xác 100% khi trừ và bình phương
            $sum += pow((float)$vectorA[$i] - (float)$vectorB[$i], 2);
        }

        return sqrt($sum);
    }
}
