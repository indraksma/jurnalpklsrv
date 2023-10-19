<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jurnal_detail()
    {
        return $this->hasOne(JurnalDetail::class);
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_ajaran::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
    public function jenis_kegiatan()
    {
        return $this->belongsTo(Jenis_kegiatan::class);
    }
}
