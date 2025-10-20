<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = [
        'audit_id', 'title', 'description', 'consequence'
    ];

    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id');
    }
}
