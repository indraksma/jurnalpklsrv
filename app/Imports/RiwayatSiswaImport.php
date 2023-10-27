<?php

namespace App\Imports;

use App\Models\RiwayatSiswa;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class RiwayatSiswaImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $siswa = Siswa::where('nis', $row[1])->first();
        return new RiwayatSiswa([
            'siswa_id' => $siswa->id,
            'riwayat' => $row[2],
            'keterangan' => $row[3],
        ]);
    }
}
