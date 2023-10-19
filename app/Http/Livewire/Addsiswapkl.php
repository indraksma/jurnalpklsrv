<?php

namespace App\Http\Livewire;

use App\Models\Dudi;
use Livewire\Component;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Siswa_pkl;
use App\Models\Tahun_ajaran;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class Addsiswapkl extends Component
{
    use LivewireAlert;

    public $jurusan, $data_kelas, $kelas, $data_siswa, $dudi, $data_dudi, $awalpkl, $akhirpkl, $user_id;
    public $showSiswa = false;
    public $showJKD = false;

    public function mount()
    {
        if (Auth::user()->hasRole('waka')) {
            $this->user_id = Auth::user()->id;
        }
    }

    public function render()
    {
        if (Auth::user()->hasRole(['pokja', 'guru'])) {
            $this->user_id = Auth::user()->id;
        }
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        $alljurusan = Jurusan::all();
        $user = User::all();
        return view('livewire.addsiswapkl', [
            'ta' => $ta,
            'alljurusan' => $alljurusan,
            'nama_guru' => $user,
        ])->extends('layouts.app');
    }

    public function updatedAwalpkl($value)
    {
        $this->awalpkl = $value;
    }

    public function updatedAkhirpkl($value)
    {
        $messages = [
            '*.required'                => 'This column is required',
            '*.numeric'                 => 'This column is required to be filled in with number',
            '*.string'                  => 'This column is required to be filled in with letters',
        ];

        $this->validate([
            'awalpkl'      => ['required']
        ], $messages);

        $this->showJKD = true;
        $this->akhirpkl = $value;
    }

    public function updatedJurusan($id)
    {
        $this->showSiswa = false;
        $this->reset(['kelas', 'data_kelas', 'data_siswa', 'data_dudi', 'dudi']);
        $dudi = Dudi::where('jurusan_id', $id)->get();
        $this->dispatchBrowserEvent('data_dudi', ['data_dudi' => $dudi]);
        $this->data_dudi = $dudi;
    }

    public function updatedDudi()
    {
        // $this->show = false;
        // $this->reset(['kelas', 'data_kelas', 'data_siswa']);
        $data_kelas = Kelas::where('jurusan_id', $this->jurusan)->get();
        $this->dispatchBrowserEvent('data_kelas', ['data_kelas' => $data_kelas]);
        $this->data_kelas = $data_kelas;
    }

    public function updatedKelas($id)
    {
        $this->kelas = $id;
        $idSiswa = Siswa_pkl::join('siswas', 'siswa_pkls.siswa_id', '=', 'siswas.id')->select('siswa_pkls.siswa_id as sid')->where('siswas.kelas_id', $id)->orderBy('nama', 'ASC')->get();
        //dd($idSiswa);
        $this->data_siswa = Siswa::whereNotIn('id', $idSiswa)->where('kelas_id', $id)->orderBy('nama', 'ASC')->orderBy('nis', 'ASC')->with('siswapkl')->get();
        $this->showSiswa = true;
    }

    public function tambahSiswa($id)
    {
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        Siswa_pkl::create([
            'user_id'      => $this->user_id,
            'tahun_ajaran_id'  => $ta->id,
            'dudi_id'      => $this->dudi,
            'awal_pkl'      => $this->awalpkl,
            'akhir_pkl'      => $this->akhirpkl,
            'siswa_id'      => $id,
        ]);
        $idSiswa = Siswa_pkl::join('siswas', 'siswa_pkls.siswa_id', '=', 'siswas.id')->select('siswa_pkls.siswa_id as sid')->where('siswas.kelas_id', $this->kelas)->orderBy('nama', 'ASC')->get();
        $this->data_siswa = Siswa::whereNotIn('id', $idSiswa)->where('kelas_id', $this->kelas)->orderBy('nama', 'ASC')->with('siswapkl')->get();
        // dd($this->data_siswa);
        $this->alert('success', 'Siswa berhasil ditambahkan!');
    }
}
