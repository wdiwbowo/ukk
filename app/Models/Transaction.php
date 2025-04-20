<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pembayaran; // pastikan ini ditambahkan di atas


class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions'; // Nama tabel

    protected $fillable = [
        'user_id', 
        'tanggal', 
        'total_harga', 
        'metode_pembayaran'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke TransactionDetail (jika ada)
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Jika model relasinya adalah Pembayaran
public function pembayaran()
{
    return $this->hasOne(Pembayaran::class);
}


}
