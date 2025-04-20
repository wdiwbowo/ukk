<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members'; // Nama tabel

    protected $fillable = [
        'nama', 
        'telepon', 
        'poin'
    ];

    // Jika member bisa melakukan transaksi, tambahkan relasi berikut:
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
