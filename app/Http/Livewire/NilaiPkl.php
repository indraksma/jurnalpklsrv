<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use App\Models\Tahun_ajaran;
use App\Models\User;
use App\Models\Dudi;
use App\Models\Jenis_kegiatan;
use App\Models\Jurnal;
use App\Models\Jurusan;
use App\Models\NilaiPkl as ModelsNilaiPkl;
use App\Models\Siswa_pkl;

class NilaiPkl extends Component
{
    use LivewireAlert;

    public $jurusan, $data_siswa, $dudi, $data_dudi, $user_id, $ta_id, $penilai, $nilai_id;
    public $showSiswa = false;
    public $showWarning = false;
    public $nilai = [];
    public $catatan = [];

    public function mount()
    {
        if (Auth::user()->hasRole('waka')) {
            $this->user_id = Auth::user()->id;
        }
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        $this->ta_id = $ta->id;
    }
    public function render()
    {
        if (Auth::user()->hasRole(['pokja', 'guru'])) {
            $this->user_id = Auth::user()->id;
        }
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        $alljurusan = Jurusan::all();
        $user = User::all();
        return view('livewire.nilai-pkl', [
            'ta' => $ta,
            'alljurusan' => $alljurusan,
            'nama_guru' => $user,
        ])->extends('layouts.app');
    }

    public function updatedJurusan($id)
    {
        $this->reset(['dudi', 'data_siswa']);
        $this->showSiswa = false;
        $this->showWarning = false;
        $this->dudi = '';
        $dudi = Dudi::where('jurusan_id', $id)->get();
        $this->data_dudi = $dudi;
    }

    public function updatedDudi($id)
    {
        $this->showSiswa = false;
        $this->showWarning = false;
        $this->reset('data_siswa');
        $kunci = Jenis_kegiatan::where('kunci', 1)->first();
        $cekjurnal = Jurnal::where('dudi_id', $id)->where('jenis_kegiatan_id', $kunci->id)->count();
        if ($cekjurnal == 0) {
            $this->showWarning = true;
        } else {
            $ceknilai = ModelsNilaiPkl::where('dudi_id', $id)->get();
            if ($ceknilai->isEmpty()) {
                $this->data_siswa = Siswa_pkl::where('dudi_id', $id)->get();
            } else {
                $this->data_siswa = $ceknilai;
                foreach ($ceknilai as $key => $data) {
                    $this->nilai_id[$key] = $data->id;
                    $this->nilai[$key] = $data->nilai;
                    $this->catatan[$key] = $data->catatan;
                }
                $this->penilai = User::where('id', $ceknilai[0]->user_id)->first()->name;
            }
            $this->showSiswa = true;
        }
    }

    public function store()
    {
        foreach ($this->data_siswa as $key => $siswa) {
            if ($this->catatan[$key]) {
                ModelsNilaiPkl::updateOrcreate(['id' => $this->nilai_id[$key]], [
                    'user_id' => $this->user_id,
                    'tahun_ajaran_id' => $this->ta_id,
                    'siswa_id' => $siswa->siswa_id,
                    'kelas_id' => $siswa->siswa->kelas_id,
                    'dudi_id' => $this->dudi,
                    'nilai' => $this->nilai[$key],
                    'catatan' => $this->catatan[$key],
                ]);
            } else {
                ModelsNilaiPkl::updateOrcreate(['id' => $this->nilai_id[$key]], [
                    'user_id' => $this->user_id,
                    'tahun_ajaran_id' => $this->ta_id,
                    'siswa_id' => $siswa->siswa_id,
                    'kelas_id' => $siswa->siswa->kelas_id,
                    'dudi_id' => $this->dudi,
                    'nilai' => $this->nilai[$key],
                    'catatan' => '-',
                ]);
            }
        }
        $this->alert('success', 'Data nilai berhasil disimpan');
        $this->reset(['nilai', 'catatan', 'dudi', 'jurusan', 'penilai']);
        $this->dudi = '';
        $this->showSiswa = false;
    }
}
