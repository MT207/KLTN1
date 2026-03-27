<?php

namespace App\Http\Controllers;

use App\Models\ChucNang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class ChucNangController extends Controller
{
    public function index()
    {
        $data = ChucNang::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = ChucNang::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = ChucNang::where('id', $request->id)->first();
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
        $data = ChucNang::where('id', $request->id)->first();
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
        $query = ChucNang::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ten_chuc_nang', 'like', '%' . $keyword . '%');
                $q->orWhere('ma_chuc_nang', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
