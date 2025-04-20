<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Pembayaran;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PetugasController extends Controller
{

       //admin
    public function index()
    {
       $pembelian = Transaction::all(); // Ambil data transaksi
       $products = Product::all(); // Ambil semua produk dari database
       return view('admin.PembelianAdmin', compact('pembelian', 'products'));
    }
   
   public function show($id)
   {
       // Ambil detail pembelian berdasarkan ID
       $transaction = Pembelian::findOrFail($id);
       return view('admin.pembelian.show', compact('transaction'));
   }

    public function createPembayaran($transactionId)
    {
        session(['transactionId' => $transactionId]); // SET session
        $transaction = Transaction::findOrFail($transactionId);
        return view('petugas.tambah-pembayaran', compact('transaction'));
    }

    public function keranjang(Request $request)
    {
        $items = json_decode($request->selectedItems, true); // ambil dari request POST
        return view('petugas.PembayaranPetugas', compact('items'));
    }

    public function indexPembelian(Request $request)
    {
        $search = $request->input('search'); // Ambil parameter pencarian dari request
    
        // Ambil transaksi berdasarkan pencarian nama pelanggan atau tanggal
        $pembelian = Transaction::with('user')
                                ->when($search, function($query, $search) {
                                    return $query->whereHas('user', function($q) use ($search) {
                                        $q->where('metode_pembayaran', 'like', "%{$search}%");
                                    })
                                    ->orWhereDate('tanggal', 'like', "%{$search}%");
                                })
                                ->paginate(10); // Gunakan pagination
    
        $products = Product::all();
        return view('petugas.PembelianPetugas', compact('pembelian', 'products'));
    }
    
    public function storeTransaction(Request $request)
{
    // Log request untuk memastikan data sampai
    Log::info('Data request:', $request->all());
    $request->validate([
        'user_id' => 'required',
        'jumlah_bayar' => 'required',
        'metode_pembayaran' => 'required',
        // 'items' => 'required|array',
        // 'items.*.product_id' => 'required|exists:products,id',
        // 'items.*.jumlah' => 'required|numeric|min:1',
    ]);

    DB::beginTransaction();

    try {
        $items = json_decode($request->input('items_json'), true); // array asosiatif
        $totalBelanja = 0;
        
        foreach ($items as $item) {
            $product = Product::where('name_product', $item['name_product'])->first();
            $subtotal = $product->harga * $item['jumlah'];
            $totalBelanja += $subtotal;

            // Kurangi stok produk
            if ($product->stok >= $item['jumlah']) {
                $product->stok -= $item['jumlah'];
                $product->save();
            } else {
                // Jika stok tidak cukup, batalkan transaksi
                DB::rollBack();
                return back()->with('error', 'Stok produk tidak mencukupi');
            }
        }

        Log::info('Total Belanja: ' . $totalBelanja);

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'tanggal' => now(),
            'total_harga' => $totalBelanja,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        foreach ($items as $item) {
            $product = Product::where('name_product', $item['name_product'])->first();
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'jumlah' => $item['jumlah'],
                'subtotal' => $product->harga * $item['jumlah'],
            ]);
        }

        $jumlahBayar = $request->jumlah_bayar;
        $kembalian = $jumlahBayar - $totalBelanja;

        Pembayaran::create([
            'transaction_id' => $transaction->id,
            'jumlah_bayar' => $jumlahBayar,
            'kembalian' => $kembalian >= 0 ? $kembalian : 0,
            'status' => 'sukses',
        ]);

        DB::commit();

        Log::info('Transaksi berhasil', ['transaction_id' => $transaction->id]);

        return redirect()->route('petugas.showPembayaran', ['transactionId' => $transaction->id])
                         ->with('success', 'Pembayaran berhasil!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error saat menyimpan transaksi: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

       
public function showPembayaran($transactionId)
{
    $transaction = Transaction::with(['details.product', 'pembayaran'])->findOrFail($transactionId);
    return view('petugas.hasilpembayaran', compact('transaction'));
}

public function showMember(Request $request)
{
    $phone = $request->query('phone');
    $member = Member::where('phone', $phone)->first();

    if (!$member) {
        return redirect()->back()->with('error', 'Member tidak ditemukan.');
    }

    return view('petugas.member', compact('member'));
}

public function handlePayment(Request $request)
{
    try {
        // Validasi input amount
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Mengambil jumlah pembayaran
        $amount = $request->amount;

        Log::info('Payment amount received:', ['amount' => $amount]);

        // Menghitung poin yang didapat berdasarkan jumlah pembayaran
        $poin = $amount * 0.01; // Misalnya 1% dari jumlah pembayaran

        // Pastikan user sedang login
        $userId = auth()->id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi.',
            ], 401); // Unauthorized
        }

        // Membuat transaksi
        $transaction = Transaction::create([
            'user_id' => $userId,
            'tanggal' => now(),
            'total_harga' => $amount,
            'metode_pembayaran' => 'member',   // Sesuaikan jika perlu
        ]);

        // Membuat pembayaran
        Pembayaran::create([
            'transaction_id' => $transaction->id,
            'jumlah_bayar' => $amount,
            'kembalian' => 0,
            'status' => 'sukses',
        ]);

        // Mendapatkan member yang sedang login
        $member = Member::find($userId);
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404); // Not Found
        }

        // Menambahkan poin ke member
        $member->poin += $poin; // Menambahkan poin ke member yang sedang login
        $member->save(); // Simpan perubahan poin ke database

        // Mengembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dan poin berhasil ditambahkan.',
            'transaction_id' => $transaction->id,
            'poin' => $member->poin, // Menampilkan poin terbaru
        ]);
    } catch (\Exception $e) {
        // Menangani error jika terjadi kesalahan
        Log::error('Error saat handlePayment: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500); // Internal Server Error
    }
}

}