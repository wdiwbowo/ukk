<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Nama tabel

    protected $fillable = [
        'name_product', 
        'harga', 
        'stok', 
        'gambar',
        'kategori'
    ];
}
