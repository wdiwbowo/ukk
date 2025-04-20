<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details'; // Nama tabel

    protected $fillable = [
        'transaction_id', 
        'product_id', 
        'jumlah', 
        'subtotal'
    ];

    // Relasi ke Transaction (1 detail milik 1 transaksi)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke Product (1 detail memiliki 1 produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
