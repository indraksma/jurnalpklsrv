<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAspek extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nilai_pkl()
    {
        return $this->belongsTo(NilaiPkl::class);
    }

    public function tujuan_pembelajaran()
    {
        return $this->belongsTo(TujuanPembelajaran::class);
    }
}
