<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomended extends Model
{
    use HasFactory;

    protected $table = 'recomendeds';
    protected $primaryKey = 'id';

    protected $fillable = ['id_temuan', 'title', 'status', 'closed_file_surat', 'batas_waktu', 'pic'];

    public function temuan()
    {
        return $this->belongsTo(Temuan::class, 'id_temuan');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'id_recomendeds');
    }

    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id'); // pastikan foreign key-nya benar
    }
}
