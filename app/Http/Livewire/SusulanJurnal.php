<?php

namespace App\Http\Livewire;

use App\Models\Dudi;
use App\Models\Jenis_kegiatan;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\LinkDokumentasi;
use App\Models\Siswa_pkl;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Tahun_ajaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SusulanJurnal extends Component
{
    use LivewireAlert;

    public $showSiswa = false;
    public $dudi, $user, $jeniskeg, $siswa, $dudi_list, $tanggal, $jumlahsiswapkl;
    public $siswaid = [];
    public $kehadiran = [];
    public $keterangan = [];
    public $materi = [];

    private $cekform = true;

    protected $rules = [
        'dudi' => 'required',
        'jeniskeg' => 'required',
        'user' => 'required',
        'tanggal' => 'required',
    ];


    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function render()
    {
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        $jeniskeg = Jenis_kegiatan::all();
        $dudi_pkl = Siswa_pkl::where('user_id', Auth::user()->id)->groupBy('dudi_id')->pluck('dudi_id');
        $dudi_list = Dudi::whereIn('id', $dudi_pkl)->get();
        $this->dudi_list = $dudi_list;
        $user = User::where('id', auth()->user()->id)->first();
        $this->user = $user->id;
        return view('livewire.susulan-jurnal', [
            'ta' => $ta,
            'data_dudi' => $dudi_list,
            'users' => $user,
            'jk' => $jeniskeg,
        ])->extends('layouts.app');
    }

    public function updatedUser($id)
    {
        $this->reset('dudi');
        $this->dudi = '';
        $dudi_pkl = Siswa_pkl::where('user_id', $id)->groupBy('dudi_id')->pluck('dudi_id');
        $this->dudi_list = Dudi::whereIn('id', $dudi_pkl)->get();
        $this->cekform();
    }

    public function updatedDudi()
    {
        $this->reset('siswaid');
        $siswapkl = Siswa_pkl::where('user_id', $this->user)->where('dudi_id', $this->dudi)->get();
        if ($siswapkl) {
            $this->reset('kehadiran');
            $this->jumlahsiswapkl = Siswa_pkl::where('user_id', $this->user)->where('dudi_id', $this->dudi)->count();
            foreach ($siswapkl as $key => $s) {
                $this->siswaid[$key] = $s->siswa->id;
            }
        }
        $this->siswa = $siswapkl;
        $this->cekform();
    }

    public function UpdatedJeniskeg()
    {
        $this->cekform();
    }

    private function cekform()
    {
        if ($this->dudi == "") {
            $this->cekform = false;
        }
        if ($this->user == "") {
            $this->cekform = false;
        }
        if ($this->jeniskeg == "") {
            $this->cekform = false;
        }
        if ($this->cekform) {
            $this->showSiswa = true;
            for ($i = 0; $i < $this->jumlahsiswapkl; $i++) {
                $this->kehadiran[$i] = 'H';
            }
        } else {
            $this->showSiswa = false;
        }
    }

    public function updatedTanggal()
    {
        if ($this->tanggal > date('Y-m-d')) {
            $this->alert('warning', 'Tanggal susulan tidak boleh melebihi hari ini!');
            $this->reset('tanggal');
            $this->tanggal = date('Y-m-d');
        }
    }

    public function store()
    {
        $this->validate();

        $ta = Tahun_ajaran::where('aktif', 1)->first();
        $link_doc = LinkDokumentasi::where('tahun_ajaran_id', $ta->id)->where('user_id', $this->user)->first();
        $jurnal = Jurnal::create([
            'user_id'      => $this->user,
            'tahun_ajaran_id'  => $ta->id,
            'dudi_id'      => $this->dudi,
            'jenis_kegiatan_id'      => $this->jeniskeg,
            'link_dokumentasi'      => $link_doc->link_dokumentasi,
            'tanggal'      => $this->tanggal,
        ]);
        foreach ($this->siswaid as $key => $jd) {
            if (isset($this->keterangan[$key])) {
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'siswa_id' => $jd,
                    'materi' => $this->materi[$key],
                    'kehadiran' => $this->kehadiran[$key],
                    'keterangan' => $this->keterangan[$key],
                ]);
            } else {
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'siswa_id' => $jd,
                    'materi' => $this->materi[$key],
                    'kehadiran' => $this->kehadiran[$key],
                    'keterangan' => '-',
                ]);
            }
        }
        $this->alert('success', 'Jurnal berhasil disimpan');
        return redirect()->route('jurnal');
    }
}
