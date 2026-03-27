<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class ChucVuController extends Controller
{
    public function index()
    {
        $data = ChucVu::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = ChucVu::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = ChucVu::where('id', $request->id)->first();
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
        $data = ChucVu::where('id', $request->id)->first();
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
        $query = ChucVu::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ten_chuc_vu', 'like', '%' . $keyword . '%');
                $q->orWhere('mo_ta', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
