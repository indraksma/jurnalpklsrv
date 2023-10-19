<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa_pkl extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
