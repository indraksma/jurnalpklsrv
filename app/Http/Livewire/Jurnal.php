<?php

namespace App\Http\Livewire;

use App\Models\Jurnal as ModelsJurnal;
use App\Models\JurnalDetail;
use App\Models\Siswa_pkl;
use App\Models\Tahun_ajaran;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Jurnal extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $searchTerm = '';
    protected $listeners = ['deleteId'];
    public $deleteid;

    public function render()
    {
        $ta_id = Tahun_ajaran::where('aktif', 1)->pluck('id');
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        $user_id = Auth::user()->id;
        $cek_siswa = Siswa_pkl::where('user_id', $user_id)->where('tahun_ajaran_id', $ta_id)->count();
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('waka')) {
            $jurnal = ModelsJurnal::where('tahun_ajaran_id', $ta_id)->orderBy('tanggal', 'DESC')->get();
        } else {
            // $jurnal = ModelsJurnal::where('tahun_ajaran_id', $ta_id)->where('user_id', $user_id)->orderBy('tanggal', 'DESC')->paginate(10);
            $jurnal = ModelsJurnal::select('jurnals.id', 'jurnals.tanggal', 'dudis.nama_dudi', 'jenis_kegiatans.nama_kegiatan', 'jurnals.link_dokumentasi')->join('dudis', 'jurnals.dudi_id', '=', 'dudis.id')
                ->join('jenis_kegiatans', 'jurnals.jenis_kegiatan_id', '=', 'jenis_kegiatans.id')
                ->where('jurnals.tahun_ajaran_id', $ta_id)->where('jurnals.user_id', $user_id)->where(function ($sub_query) {
                    $query = '%' . $this->searchTerm . '%';
                    $sub_query->where('jurnals.tanggal', 'like', $query)
                        ->orWhere('dudis.nama_dudi', 'like', $query)
                        ->orWhere('jenis_kegiatans.nama_kegiatan', 'like', $query);
                })->orderBy('tanggal', 'DESC')->paginate(10);
        }
        return view('livewire.jurnal', [
            'cek_siswa' => $cek_siswa,
            'ta' => $ta,
            'jurnal' => $jurnal,
        ])->extends('layouts.app');
    }

    public function deleteId($id)
    {
        $this->deleteid = $id;
    }

    public function delete()
    {
        // dd($this->deleteid);
        JurnalDetail::where('jurnal_id', $this->deleteid)->delete();
        ModelsJurnal::where('id', $this->deleteid)->delete();

        $this->alert('warning', 'Data berhasil dihapus!');
        $this->emit('refreshJurnalTable');
    }
}
