<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Jurnal;
use App\Models\Kelas;
use PDF;

class CetakController extends Controller
{
    public function cetak_laporan($siswaid, $ta, $bulan)
    {
        $siswa = Siswa::where('id', $siswaid)->first();
        $jurnal_all = Jurnal::join('jurnal_details', 'jurnals.id', '=', 'jurnal_details.jurnal_id')->where('jurnals.tahun_ajaran_id', $ta)->where('jurnal_details.siswa_id', $siswaid)->whereMonth('tanggal', '=', $bulan)->get();
        $jurnal = Jurnal::join('jurnal_details', 'jurnals.id', '=', 'jurnal_details.jurnal_id')->where('jurnals.tahun_ajaran_id', $ta)->where('jurnal_details.siswa_id', $siswaid)->whereMonth('tanggal', '=', $bulan)->first();
        $pdf = PDF::loadView('cetak.laporan_pembelajaran', ['jurnal' => $jurnal, 'jurnal_all' => $jurnal_all, 'bulan' => $bulan, 'siswa' => $siswa]);
        $pdf->setPaper('A4', 'portrait');
        $namadokumen = $siswa->nama . '-laporan-pembelajaran-pkl-' . $bulan . '.pdf';
        return $pdf->download($namadokumen);
    }

    public function cetak_kelas($kelasid)
    {
        $kelas = Kelas::where('id', $kelasid)->first();
        $siswa = Siswa::where('kelas_id', $kelasid)->orderBy('nis', 'ASC')->get();
        // dd($kelas);
        $pdf = PDF::loadView('cetak.laporan_kelas', ['siswa' => $siswa, 'kelas' => $kelas]);
        $pdf->setPaper('A4', 'portrait');
        $namadokumen = $kelas->nama_kelas . '-laporan-siswa-pkl.pdf';
        return $pdf->download($namadokumen);
    }
}
