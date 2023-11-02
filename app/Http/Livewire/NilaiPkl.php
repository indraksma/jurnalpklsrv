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
use App\Models\NilaiAspek;
use App\Models\NilaiPkl as ModelsNilaiPkl;
use App\Models\Siswa;
use App\Models\Siswa_pkl;
use App\Models\TujuanPembelajaran;

class NilaiPkl extends Component
{
    use LivewireAlert;

    public $jurusan, $data_siswa, $siswa, $siswa_id, $dudi, $data_dudi, $user_id, $ta_id, $penilai, $data_nilai;
    public $showSiswa = false;
    public $showWarning = false;
    public $nilai_id = [];
    public $tp_id = [];
    public $nilai_p1 = [];
    public $nilai_p2 = [];
    public $edit_nilai = false;

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
        $this->reset(['dudi', 'data_siswa', 'nilai_p1', 'nilai_p2']);
        $this->edit_nilai = false;
        $this->showSiswa = false;
        $this->showWarning = false;
        $this->dudi = '';
        if (Auth::user()->hasRole(['pokja', 'guru'])) {
            $userid = Auth::user()->id;
            $dudipkl = Siswa_pkl::where('user_id', $userid)->where('tahun_ajaran_id', $this->ta_id)->pluck('dudi_id');
            $dudi = Dudi::whereIn('id', $dudipkl)->where('jurusan_id', $id)->get();
        } else {
            $dudi = Dudi::where('jurusan_id', $id)->get();
        }
        $this->data_dudi = $dudi;
    }

    public function updatedDudi($id)
    {
        $this->edit_nilai = false;
        $this->showSiswa = false;
        $this->showWarning = false;
        $this->reset(['siswa_id', 'data_siswa', 'nilai_p1', 'nilai_p2']);

        if (Auth::user()->hasRole(['pokja', 'guru'])) {
            $this->siswa = Siswa_pkl::where('dudi_id', $id)->where('tahun_ajaran_id', $this->ta_id)->where('user_id', $this->user_id)->get();
        } else {
            $this->siswa = Siswa_pkl::where('dudi_id', $id)->where('tahun_ajaran_id', $this->ta_id)->get();
        }
    }

    public function updatedSiswaId($id)
    {
        $this->edit_nilai = false;
        $this->showSiswa = false;
        $this->showWarning = false;
        $this->reset(['data_siswa', 'data_nilai', 'nilai_p1', 'nilai_p2', 'tp_id', 'penilai']);
        if ($id != '') {
            $kunci = Jenis_kegiatan::where('kunci', 1)->first();
            $cekjurnal = Jurnal::where('dudi_id', $this->dudi)->where('jenis_kegiatan_id', $kunci->id)->count();
            if ($cekjurnal == 0) {
                $this->showWarning = true;
            } else {
                $ceknilai = ModelsNilaiPkl::where('siswa_id', $id)->first();
                $this->data_siswa = Siswa::where('id', $id)->first();
                if ($ceknilai == NULL) {
                    $this->data_nilai = TujuanPembelajaran::where('tahun_ajaran_id', $this->ta_id)->get();
                    $data_nilai = $this->data_nilai;
                    foreach ($data_nilai as $key => $data) {
                        $this->nilai_id[$key] = NULL;
                        $this->tp_id[$key] = $data->id;
                    }
                } else {
                    $this->edit_nilai = true;
                    $this->data_nilai = NilaiAspek::where('nilai_pkl_id', $ceknilai->id)->get();
                    $data_nilai = $this->data_nilai;
                    foreach ($data_nilai as $key => $data) {
                        $this->nilai_id[$key] = $data->id;
                        $this->tp_id[$key] = $data->tujuan_pembelajaran_id;
                        $this->nilai_p1[$key] = $data->nilai_p1;
                        $this->nilai_p2[$key] = $data->nilai_p2;
                    }
                    $this->penilai = User::where('id', $ceknilai->user_id)->first()->name;
                }
                $this->showSiswa = true;
            }
        }
    }

    public function store()
    {
        $nilaisum = 0;
        $ceknilai = ModelsNilaiPkl::where('siswa_id', $this->data_siswa->id)->first();
        if ($ceknilai == NULL) {
            $nilai_pkl = ModelsNilaiPkl::create([
                'user_id' => $this->user_id,
                'tahun_ajaran_id' => $this->ta_id,
                'siswa_id' => $this->data_siswa->id,
                'kelas_id' => $this->data_siswa->kelas_id,
                'dudi_id' => $this->dudi
            ]);
        } else {
            $nilai_pkl = $ceknilai;
        }
        foreach ($this->data_nilai as $key => $nilai) {
            NilaiAspek::updateOrcreate(['id' => $this->nilai_id[$key]], [
                'nilai_pkl_id' => $nilai_pkl->id,
                'tujuan_pembelajaran_id' => $this->tp_id[$key],
                'nilai_p1' => $this->nilai_p1[$key],
                'nilai_p2' => $this->nilai_p2[$key],
            ]);
            $nilaisum = $nilaisum + (($this->nilai_p1[$key] + $this->nilai_p2[$key]) / 2);
        }
        $nilaiakhir = $nilaisum / 4;

        $updatenilai = ModelsNilaiPkl::where('id', $nilai_pkl->id)->first();
        $updatenilai->nilai_akhir = $nilaiakhir;
        $updatenilai->save();

        $this->alert('success', 'Data nilai berhasil disimpan');
        $this->reset(['siswa_id', 'nilai_id', 'tp_id', 'nilai_p1', 'nilai_p2', 'edit_nilai']);
        $this->showSiswa = false;
    }

    public function resetData()
    {
        $data_nilai = ModelsNilaiPkl::where('siswa_id', $this->siswa_id)->first();
        NilaiAspek::where('nilai_pkl_id', $data_nilai->id)->delete();
        ModelsNilaiPkl::where('id', $data_nilai->id)->delete();

        $this->reset(['nilai_id', 'tp_id', 'nilai_p1', 'nilai_p2', 'edit_nilai']);
        $this->alert('warning', 'Data berhasil dihapus');
    }
}
