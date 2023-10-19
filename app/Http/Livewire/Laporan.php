<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Dudi;
use App\Models\Jurnal;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa_pkl;
use App\Models\Tahun_ajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Laporan extends Component
{
    use LivewireAlert;

    public $user_id, $guru, $dudi, $laporan_type, $jenis_laporan, $dudi_id, $bulan, $siswa, $ta_id, $list_jurusan, $jurusan_id, $kelas_id, $list_kelas;
    public $showSiswa = false;
    public $showPrintBtn = false;

    public function mount()
    {
        if (Auth::user()->hasRole(['guru', 'pokja'])) {
            $this->guru = Auth::user()->name;
            $this->user_id = Auth::user()->id;
        }
        $tahun_ajaran = Tahun_ajaran::where('aktif', 1)->first();
        $this->ta_id = $tahun_ajaran->id;
    }

    public function render()
    {
        $tahun_ajaran = Tahun_ajaran::all();
        $user = User::all();
        return view('livewire.laporan', [
            'tahun_ajaran' => $tahun_ajaran,
            'nama_guru' => $user,
        ])->extends('layouts.app');
    }

    public function updatedJenisLaporan($type)
    {
        $this->reset(['laporan_type', 'dudi', 'dudi_id', 'bulan', 'siswa', 'list_jurusan', 'list_kelas', 'jurusan_id', 'kelas_id']);
        $this->showSiswa = false;
        $this->showPrintBtn = false;
        $this->laporan_type = $type;
        if ($type == 1) {
            $this->jurusan_id = '';
            $this->kelas_id = '';
            $this->list_jurusan = Jurusan::all();
        } else {
            if (Auth::user()->hasRole(['guru', 'pokja'])) {
                $this->guru = Auth::user()->name;
                $this->user_id = Auth::user()->id;
                $dudi_pkl = Siswa_pkl::where('user_id', $this->user_id)->groupBy('dudi_id')->pluck('dudi_id');
                $dudi_list = Dudi::whereIn('id', $dudi_pkl)->get();
                $this->dudi = $dudi_list;
            } else {
                $this->user_id = '';
            }
            $this->dudi_id = '';
        }
    }

    public function updatedJurusanId($id)
    {
        $this->reset(['kelas_id', 'list_kelas']);
        $this->showPrintBtn = false;
        $this->list_kelas = Kelas::where('jurusan_id', $id)->where('tahun_ajaran_id', $this->ta_id)->get();
    }

    public function updatedKelasId()
    {
        $this->showPrintBtn = true;
    }

    public function updatedUserId($id)
    {
        $this->reset(['dudi_id', 'bulan', 'siswa']);
        $this->showSiswa = false;
        $dudi_pkl = Siswa_pkl::where('user_id', $id)->groupBy('dudi_id')->pluck('dudi_id');
        $dudi_list = Dudi::whereIn('id', $dudi_pkl)->get();
        $this->dudi = $dudi_list;
    }

    public function updatedDudiId()
    {
        $this->reset(['bulan', 'siswa']);
        $this->showSiswa = false;
    }

    public function updatedBulan($bulan)
    {
        $this->showSiswa = true;
        $siswa = Siswa_pkl::where('user_id', $this->user_id)->where('dudi_id', $this->dudi_id)->get();
        $this->siswa = $siswa;
    }

    public function cetakLaporan1()
    {
        return redirect()->route('cetak.laporan1', [$this->kelas_id]);
    }

    public function cetakLaporan2($siswaid)
    {
        $jurnal_all = Jurnal::join('jurnal_details', 'jurnals.id', '=', 'jurnal_details.jurnal_id')->where('jurnals.tahun_ajaran_id', $this->ta_id)->where('jurnal_details.siswa_id', $siswaid)->whereMonth('tanggal', '=', $this->bulan)->get();
        if (!$jurnal_all->isEmpty()) {
            return redirect()->route('cetak.laporan2', [$siswaid, $this->ta_id, $this->bulan]);
        } else {
            $this->alert('error', 'Data tidak ditemukan!');
        }
    }
}
