<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;
    protected $fillable = [
        'audit_id', 'title', 'consequence', 'type_finding', 'mark_finding', 'reason', 'criteria'
    ];

    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id');
    }

    public function getReasonAttribute($value)
    {
        return $value ? json_decode($value) : null;
    }

    public function getCriteriaAttribute($value)
    {
        return $value ? json_decode($value) : null;
    }
}
