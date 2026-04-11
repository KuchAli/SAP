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
        'kategori'
        
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }
}
