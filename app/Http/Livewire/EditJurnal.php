<?php

namespace App\Http\Livewire;

use App\Models\Dudi;
use App\Models\Jenis_kegiatan;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\Siswa;
use App\Models\Siswa_pkl;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Tahun_ajaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EditJurnal extends Component
{
    use LivewireAlert;

    public $idjurnal;
    protected $queryString = ['idjurnal'];
    public $dudi, $user, $jeniskeg, $siswa, $dudi_list, $link_dokumentasi, $tanggal, $jurnal_detail;
    public $siswaid = [];
    public $kehadiran = [];
    public $keterangan = [];
    public $materi = [];

    protected $rules = [
        'dudi' => 'required',
        'jeniskeg' => 'required',
        'link_dokumentasi' => 'required',
        'user' => 'required',
    ];

    public function mount()
    {
        $jurnal = Jurnal::where('id', $this->idjurnal)->first();
        $this->jeniskeg = $jurnal->jenis_kegiatan_id;
        $this->dudi = $jurnal->dudi_id;
        if (Auth::user()->hasRole('admin')) {
            $this->tanggal = $jurnal->tanggal;
        } else {
            $this->tanggal = date_format(date_create($jurnal->tanggal), 'j F Y');
        }
        $this->link_dokumentasi = $jurnal->link_dokumentasi;
        $jurnal_detail = JurnalDetail::where('jurnal_id', $jurnal->id)->get();
        $this->siswa = $jurnal_detail;
        $this->jurnal_detail = $jurnal_detail;
        foreach ($jurnal_detail as $key => $jd) {
            $this->siswaid[$key] = $jd->siswa_id;
            $this->materi[$key] = $jd->materi;
            $this->keterangan[$key] = $jd->keterangan;
            $this->kehadiran[$key] = $jd->kehadiran;
        }
    }

    public function render()
    {

        $jurnal = Jurnal::where('id', $this->idjurnal)->first();
        $ta = Tahun_ajaran::where('id', $jurnal->tahun_ajaran_id)->first();
        $jeniskeg = Jenis_kegiatan::all();
        $user = User::where('id', $jurnal->user_id)->first();
        $this->user = $user->id;

        $dudi_list = Dudi::where('id', $jurnal->dudi_id)->first();
        $this->dudi_list = $dudi_list->nama_dudi;
        return view('livewire.edit-jurnal', [
            'ta' => $ta,
            'data_dudi' => $dudi_list,
            'users' => $user,
            'jk' => $jeniskeg,
        ])->extends('layouts.app');
    }

    public function update()
    {
        $this->validate();

        $jurnal = Jurnal::where('id', $this->idjurnal)->first();

        if (Auth::user()->hasRole('admin')) {
            $jurnal->update([
                'tanggal'   => $this->tanggal,
                'jenis_kegiatan_id'      => $this->jeniskeg,
                'link_dokumentasi'      => $this->link_dokumentasi,
            ]);
        } else {
            $jurnal->update([
                'jenis_kegiatan_id'      => $this->jeniskeg,
                'link_dokumentasi'      => $this->link_dokumentasi,
            ]);
        }
        foreach ($this->jurnal_detail as $key => $jd) {
            $jd_edit = JurnalDetail::where('id', $jd->id)->first();
            if (isset($this->keterangan[$key])) {
                $jd_edit->update([
                    'materi' => $this->materi[$key],
                    'kehadiran' => $this->kehadiran[$key],
                    'keterangan' => $this->keterangan[$key],
                ]);
            } else {
                $jd_edit->update([
                    'materi' => $this->materi[$key],
                    'kehadiran' => $this->kehadiran[$key],
                    'keterangan' => '-',
                ]);
            }
        }
        $this->alert('success', 'Jurnal berhasil diubah');
        return redirect()->route('jurnal');
    }
}
