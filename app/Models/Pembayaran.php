<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans'; // Nama tabel

    protected $fillable = [
        'transaction_id', 
        'jumlah_bayar', 
        'kembalian', 
        'status'
    ];

    // Relasi ke Transaction (1 pembayaran milik 1 transaksi)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
