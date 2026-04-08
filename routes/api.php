<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\ChucNangController;
use App\Http\Controllers\ChiTietPhanQuyenController;
use App\Http\Controllers\DoiTacController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\GoiController;
use App\Http\Controllers\ChiTietGoiController;
use App\Http\Controllers\PhongHopController;
use App\Http\Controllers\ChiTietPhongHopController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\HoaDonController;

// Admin
Route::post('/admin/login', [AdminController::class, 'login']);
// Route::get('/admin/data-chi-tiet/{admin}', [AdminController::class, 'show']);
Route::get('/admin/data', [AdminController::class, 'index']);
Route::post('/admin/create', [AdminController::class, 'store']);
Route::post('/admin/update', [AdminController::class, 'update']);
Route::post('/admin/delete', [AdminController::class, 'destroy']);

// 1. Chức Vụ
Route::get('/chuc-vu/data', [ChucVuController::class, 'index']);
Route::post('/chuc-vu/create', [ChucVuController::class, 'store']);
Route::post('/chuc-vu/update', [ChucVuController::class, 'update']);
Route::post('/chuc-vu/delete', [ChucVuController::class, 'destroy']);
Route::post('/chuc-vu/tim-kiem', [ChucVuController::class, 'search']);

// 2. Chức Năng
Route::get('/chuc-nang/data', [ChucNangController::class, 'index']);
Route::post('/chuc-nang/create', [ChucNangController::class, 'store']);
Route::post('/chuc-nang/update', [ChucNangController::class, 'update']);
Route::post('/chuc-nang/delete', [ChucNangController::class, 'destroy']);
Route::post('/chuc-nang/tim-kiem', [ChucNangController::class, 'search']);

// 3. Chi Tiết Phân Quyền
Route::get('/chi-tiet-phan-quyen/data', [ChiTietPhanQuyenController::class, 'index']);
Route::post('/chi-tiet-phan-quyen/create', [ChiTietPhanQuyenController::class, 'store']);
Route::post('/chi-tiet-phan-quyen/update', [ChiTietPhanQuyenController::class, 'update']);
Route::post('/chi-tiet-phan-quyen/delete', [ChiTietPhanQuyenController::class, 'destroy']);

// 4. Đối Tác
Route::get('/doi-tac/data', [DoiTacController::class, 'index']);
Route::post('/doi-tac/create', [DoiTacController::class, 'store']);
Route::post('/doi-tac/update', [DoiTacController::class, 'update']);
Route::post('/doi-tac/delete', [DoiTacController::class, 'destroy']);
Route::post('/doi-tac/tim-kiem', [DoiTacController::class, 'search']);
Route::post('/doi-tac/change-status', [DoiTacController::class, 'changeStatus']);

// 5. Người Dùng
Route::get('/nguoi-dung/data', [NguoiDungController::class, 'index']);
Route::post('/nguoi-dung/create', [NguoiDungController::class, 'store']);
Route::post('/nguoi-dung/update', [NguoiDungController::class, 'update']);
Route::post('/nguoi-dung/delete', [NguoiDungController::class, 'destroy']);
Route::post('/nguoi-dung/tim-kiem', [NguoiDungController::class, 'search']);
Route::post('/nguoi-dung/change-status', [NguoiDungController::class, 'changeStatus']);
Route::post('/nguoi-dung/login', [NguoiDungController::class, 'login']);
Route::post('/nguoi-dung/logout', [NguoiDungController::class, 'logout']);
Route::post('/nguoi-dung/register', [NguoiDungController::class, 'register']);
// 5.1 Face ID User
Route::post('/nguoi-dung/xac-thuc-khuon-mat', [NguoiDungController::class, 'xacThucKhuonMat']);

// 6. Gói
Route::get('/goi/data', [GoiController::class, 'index']);
Route::post('/goi/create', [GoiController::class, 'store']);
Route::post('/goi/update', [GoiController::class, 'update']);
Route::post('/goi/delete', [GoiController::class, 'destroy']);
Route::post('/goi/tim-kiem', [GoiController::class, 'search']);
Route::post('/goi/change-status', [GoiController::class, 'changeStatus']);

// 7. Chi Tiết Gói
Route::get('/chi-tiet-goi/data', [ChiTietGoiController::class, 'index']);
Route::post('/chi-tiet-goi/create', [ChiTietGoiController::class, 'store']);
Route::post('/chi-tiet-goi/update', [ChiTietGoiController::class, 'update']);
Route::post('/chi-tiet-goi/delete', [ChiTietGoiController::class, 'destroy']);
Route::post('/chi-tiet-goi/change-status', [ChiTietGoiController::class, 'changeStatus']);

// 8. Phòng Họp
Route::get('/phong-hop/data', [PhongHopController::class, 'index']);
Route::post('/phong-hop/create', [PhongHopController::class, 'store']);
Route::post('/phong-hop/update', [PhongHopController::class, 'update']);
Route::post('/phong-hop/delete', [PhongHopController::class, 'destroy']);
Route::post('/phong-hop/tim-kiem', [PhongHopController::class, 'search']);
Route::post('/phong-hop/change-status', [PhongHopController::class, 'changeStatus']);
Route::get('/phong-hop/ma-phong', [PhongHopController::class, 'getByMaPhong']);
// 8.1 Phòng Họp
Route::post('/phong-hop/tao-token', [PhongHopController::class, 'taoToken']);
Route::post('/phong-hop/kiem-tra-phong-hop', [PhongHopController::class, 'kiemTraPhongHop']);

// 9. Chi Tiết Phòng Họp
Route::get('/chi-tiet-phong-hop/data', [ChiTietPhongHopController::class, 'index']);
Route::post('/chi-tiet-phong-hop/create', [ChiTietPhongHopController::class, 'store']);
Route::post('/chi-tiet-phong-hop/update', [ChiTietPhongHopController::class, 'update']);
Route::post('/chi-tiet-phong-hop/delete', [ChiTietPhongHopController::class, 'destroy']);
Route::post('/chi-tiet-phong-hop/change-status', [ChiTietPhongHopController::class, 'changeStatus']);

// 10. Chat Room
Route::get('/chat-room/data', [ChatRoomController::class, 'index']);
Route::post('/chat-room/create', [ChatRoomController::class, 'store']);
Route::post('/chat-room/update', [ChatRoomController::class, 'update']);
Route::post('/chat-room/delete', [ChatRoomController::class, 'destroy']);
Route::post('/chat-room/tim-kiem', [ChatRoomController::class, 'search']);

// 11. Hóa Đơn
Route::get('/hoa-don/data', [HoaDonController::class, 'index']);
Route::post('/hoa-don/create', [HoaDonController::class, 'store']);
Route::post('/hoa-don/update', [HoaDonController::class, 'update']);
Route::post('/hoa-don/delete', [HoaDonController::class, 'destroy']);
Route::post('/hoa-don/tim-kiem', [HoaDonController::class, 'search']);
