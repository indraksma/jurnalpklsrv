<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanPembelajaran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_ajaran::class, 'tahun_ajaran_id');
    }
}
