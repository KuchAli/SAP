<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarif extends Model
{
    use SoftDeletes;
    protected $table = 'tarifs';
    protected $primaryKey = 'id_tarif';
    protected $fillable = [
        'jenis_tarif',
        'tarif'
    ];
}
