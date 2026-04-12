<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    protected $guarded = [];
    use HasFactory , SoftDeletes;
    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';
    protected $fillable = [
        'judul_buku',
        'penulis',
        'slug_buku',
        'gambar_buku',
        'penerbit',
        'tahun_terbit',
        'status',
        'id_kategori',
        'stok'
        
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }

        public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
