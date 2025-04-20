<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaction;

class MemberController extends Controller
{
    public function create()
    {
        $selectedItems = session('selected_items', []);
        $total = session('total_pembelian', 0);
        $transaction = Transaction::where('user_id', auth()->id())->latest()->first();

        return view('petugas.member', compact('selectedItems', 'total', 'transaction'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'telepon' => 'required|string|max:15',
        'amount' => 'required|numeric',
    ]);

    // Menyimpan data member baru
    $member = Member::create([
        'nama' => $request->nama,
        'telepon' => $request->telepon,
        // Tambahkan data lain yang perlu disimpan
    ]);

    // Menghitung jumlah pembayaran dan kembalian
    $amount = $request->amount;
    $totalAmount = session('total_amount'); // Pastikan Anda menyimpan total amount di session
    $kembalian = $amount - $totalAmount;

    // Menyimpan transaksi
    $transaction = Transaction::create([
        'transaction_id' => uniqid('trans_'), // ID transaksi unik
        'jumlah_bayar' => $amount,
        'kembalian' => $kembalian,
        'status' => 'Lunas', // Atur status transaksi (misalnya Lunas)
    ]);

    // Mengupdate poin member
    $points = $totalAmount * 0.01; // Misalnya poin 1% dari total transaksi
    $member->update([
        'points' => $member->points + $points, // Tambahkan poin ke member
    ]);

    // Kirim response sukses
    return response()->json([
        'success' => true,
        'message' => 'Pendaftaran dan pembayaran berhasil!',
    ]);
}

    public function checkMember(Request $request)
    {
        $request->validate(['phone_number' => 'required|string']);
        $member = Member::where('telepon', $request->phone_number)->first();

        if ($member) {
            return response()->json([
                'exists' => true,
                'member' => [
                    'name' => $member->nama,
                    'phone_number' => $member->telepon
                ]
            ]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
