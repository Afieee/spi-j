<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    use HasFactory;

    protected $table = 'temuan';
    protected $primaryKey = 'id';
    protected $fillable = ['isi_temuan', 'jenis_temuan', 'akibat', 'id_audit'];


    public function audit()
    {
        return $this->belongsTo(Audit::class, 'id_audit');
    }

    public function recomendeds()
    {
        return $this->hasMany(Recomended::class, 'id_temuan');
    }
}
