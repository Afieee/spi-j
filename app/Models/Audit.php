<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_audit',
        'code',
        'date',
        'divisi',
        'activity',
        'file_surat_tugas',
        'file_nota_dinas',
        'closed_file_surat',
        'member',
        'status',
        'berita_acara_exit_meeting',
        'pka',
        'laporan_dan_lampiran',
    ];

    public function getFileSuratTugasAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }

    public function getFileNotaDinasAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }

    public function getMemberAttribute($value)
    {
        return $value ? json_decode($value) : null;
    }

    public function findings()
    {
        return $this->hasMany(Finding::class, 'audit_id');
    }

    public function notices()
    {
        return $this->hasMany(Notice::class, 'audit_id');
    }

    public function temuans()
    {
        return $this->hasMany(Temuan::class, 'id_audit');
    }

    public function recomendeds()
    {
        return $this->hasMany(Recomended::class, 'audit_id');
    }
}
