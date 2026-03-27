<?php

namespace App\Http\Controllers;

use App\Models\ChiTietGoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class ChiTietGoiController extends Controller
{
    public function index()
    {
        $data = ChiTietGoi::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = ChiTietGoi::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = ChiTietGoi::where('id', $request->id)->first();
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
        $data = ChiTietGoi::where('id', $request->id)->first();
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

    public function changeStatus(Request $request)
    {
        $data = ChiTietGoi::where('id', $request->id)->first();
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
}
