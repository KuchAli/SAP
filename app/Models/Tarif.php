<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarifs';
    protected $primaryKey = 'id_tarif';
    protected $fillable = [
        'jenis_tarif',
        'tarif'
    ];
}
