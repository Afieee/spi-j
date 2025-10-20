<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pkpt extends Model
{
    use HasFactory;



    protected $table = 'pkpt';
    protected $primaryKey = 'id_pkpt';
    protected $fillable = ['nama_penugasan_pkpt', 'file_pkpt'];
}
