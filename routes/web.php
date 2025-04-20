<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MemberController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::put('/products/update-stock/{id}', [ProductController::class, 'updateStock'])->name('products.updateStock');
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/admin/user', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::post('/admin/users/add', [UserController::class, 'addUser'])->name('users.add');
Route::post('/users/update/{id}', [UserController::class, 'updateUser'])->name('users.update');
Route::get('/admin/users/delete/{id}', [UserController::class, 'deleteUser'])->name('users.delete');
Route::get('pembelian', [PetugasController::class, 'index'])->name('admin.pembelian.index');
Route::get('pembelian/{id}', [PetugasController::class, 'show'])->name('admin.pembelian.detail');

Route::get('/petugas/produk', [ProductController::class, 'indexPetugas'])->name('produk.petugas');
Route::post('/products/{id}/reduce-stock', [ProductController::class, 'reduceStock'])->name('products.reduceStock');

// Route untuk halaman pembelian
Route::get('/petugas/pembelian', [PetugasController::class, 'indexPembelian'])->name('pembelian.index');
Route::get('/petugas/pembayaran/{id}', [PetugasController::class, 'createPembayaran'])->name('pembayaran.create');
Route::get('/petugas/pembayaran/', [PetugasController::class, 'keranjang'])->name('pembayaran.keranjang');
Route::post('transaksi/store', [PetugasController::class, 'storeTransaction'])->name('petugas.transaksi.store');
Route::get('/pembayaran/{transactionId}', [PetugasController::class, 'showPembayaran'])->name('petugas.showPembayaran');
Route::post('/petugas/transaksi/store', [PetugasController::class, 'storeTransaction'])->name('petugas.transaksi.store');
Route::get('/petugas/transaction/{id}/detail', [PetugasController::class, 'detailTransaction'])->name('petugas.detailTransaction');
Route::get('/petugas/member', [PetugasController::class, 'showMember'])->name('petugas.member.show');

Route::post('/pembayaran-endpoint', [PetugasController::class, 'handlePayment']);
Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');
Route::post('/petugas/check-member', [MemberController::class, 'checkMember'])->name('petugas.checkMember');

// Dashboard untuk Admin
Route::get('/admin/dashboard', function () {
    return view('admin.DashboardAdmin');
})->middleware('auth')->name('admin.dashboard');

// Dashboard untuk Petugas
Route::get('/petugas/dashboard', function () {
    return view('petugas.DashboardPetugas');
})->middleware('auth')->name('petugas.dashboard');