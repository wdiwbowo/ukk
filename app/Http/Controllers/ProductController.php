<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari request
        $search = $request->get('search');
    
        // Jika ada kata kunci pencarian, filter produk berdasarkan nama
        if ($search) {
            $products = Product::where('name_product', 'like', '%' . $search . '%')->get();
        } else {
            // Jika tidak ada pencarian, ambil semua produk
            $products = Product::all();
        }
    
        return view('admin.ProdukAdmin', compact('products'));
    }

    public function indexPetugas(Request $request)
{
    $search = $request->get('search');

    $products = $search 
        ? Product::where('name_product', 'like', '%' . $search . '%')->get()
        : Product::all();

    return view('petugas.ProdukPetugas', compact('products'));
}


public function store(Request $request)
{
    $request->validate([
        'name_product' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'kategori' => 'required|string|max:100',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $namagambar = time().'.'. $request->gambar->getClientOriginalExtension();
    $request->gambar->move(public_path('image'), $namagambar);

    Product::create([
        'name_product' => $request->name_product,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'kategori' => $request->kategori,
        'gambar' => $namagambar,
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
}


    public function reduceStock(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1', // Validasi jumlah produk yang dibeli
    ]);

    // Cari produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Cek apakah stok cukup
    if ($product->stok >= $request->quantity) {
        // Kurangi stok produk
        $product->stok -= $request->quantity;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Stok produk berhasil diperbarui!');
    } else {
        return redirect()->route('products.index')->with('error', 'Stok tidak cukup untuk transaksi ini!');
    }
}


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus gambar dari storage
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
    public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('admin.ProdukAdmin', compact('product'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name_product' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = Product::findOrFail($id);

    // Perbarui data produk
    $product->name_product = $request->name_product;
    $product->harga = $request->harga;
    $product->stok = $request->stok;

    // Periksa apakah ada gambar baru
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama
        if ($product->gambar && file_exists(public_path('image/' . $product->gambar))) {
            unlink(public_path('image/' . $product->gambar));
        }

        // Simpan gambar baru ke folder public/image
        $namagambar = time() . '.' . $request->gambar->getClientOriginalExtension();
        $request->gambar->move(public_path('image'), $namagambar);
        $product->gambar = $namagambar;
    }

    $product->save();

    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
}


public function updateStock(Request $request, $id)
{
    $request->validate([
        'stok' => 'required|integer|min:0',
    ]);

    $product = Product::findOrFail($id);
    $product->stok = $request->stok;
    $product->save();

    return redirect()->route('products.index')->with('success', 'Stok produk berhasil diperbarui!');
}



}
