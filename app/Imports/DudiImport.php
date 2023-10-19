<?php

namespace App\Imports;

use App\Models\Dudi;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;

class DudiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = Jurusan::where('kode_jurusan', 'LIKE', $row[1])->first();
        return new Dudi([
            'nama_dudi' => $row[0],
            'jurusan_id' => $id->id,
            'kab_kota' => $row[2],
            'alamat' => $row[3],
        ]);
    }
}
