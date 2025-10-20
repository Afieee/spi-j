<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table = 'tl';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_recomendeds',
        'catatan_tl',
        'status_tl',
        'batas_waktu'
    ];
    public function recomended()
    {
        return $this->belongsTo(Recomended::class, 'id_recomendeds');
    }
}
