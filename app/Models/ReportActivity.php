<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'title', 'date', 'divisi', 'description', 'attachment'
    ];

    public function getAttachmentAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }
}
