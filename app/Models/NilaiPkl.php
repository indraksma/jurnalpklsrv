<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPkl extends Model
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
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_ajaran::class);
    }
}
