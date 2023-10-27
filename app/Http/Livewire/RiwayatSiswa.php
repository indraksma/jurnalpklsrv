<?php

namespace App\Http\Livewire;

use App\Models\Jurusan;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\RiwayatSiswa as ModelsRiwayat;
use App\Models\Siswa;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Imports\RiwayatSiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class RiwayatSiswa extends Component
{
    use WithPagination, LivewireAlert, WithFileUploads;

    public $iteration = 0;
    public $editdata = false;
    public $jrs, $jurusan, $kls, $kelas_id, $siswa, $siswa_id, $riwayatkesehatan, $keterangan, $riwayat_id, $deleteid;
    public $template_excel;

    public function render()
    {
        $riwayat = ModelsRiwayat::paginate(10);
        return view('livewire.riwayat-siswa', [
            'riwayat' => $riwayat
        ])->extends('layouts.app');
    }

    private function resetForm()
    {
        $this->reset(['riwayat_id', 'jurusan', 'kelas_id', 'siswa_id', 'riwayatkesehatan', 'keterangan']);
        $this->iteration++;
        $this->editdata = false;
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    public function createModal()
    {
        $this->resetForm();
        $this->editdata = false;
        $this->jrs = Jurusan::all();
    }

    public function editModal($id)
    {
        $this->resetForm();
        $this->editdata = true;
        $this->riwayat_id = $id;
        $this->jrs = Jurusan::all();
        $riwayat = ModelsRiwayat::where('id', $id)->first();
        $siswas = Siswa::where('id', $riwayat->siswa_id)->first();
        $this->kls = Kelas::where('jurusan_id', $siswas->kelas->jurusan_id)->get();
        $this->jurusan = $siswas->kelas->jurusan_id;
        $this->kelas_id = $siswas->kelas_id;
        $this->siswa = Siswa::where('id', $riwayat->siswa_id)->get();
        $this->siswa_id = $riwayat->siswa_id;
        $this->riwayatkesehatan = $riwayat->riwayat;
        $this->keterangan = $riwayat->keterangan;
    }

    public function updatedJurusan($id)
    {
        $this->reset(['kelas_id', 'siswa_id']);
        $this->kelas_id = '';
        $this->kls = Kelas::where('jurusan_id', $id)->get();
    }

    public function updatedKelasId($id)
    {
        $this->reset(['siswa_id']);
        $this->siswa = Siswa::where('kelas_id', $id)->get();
    }

    public function store()
    {
        $messages = [
            '*.required'                => 'This column is required',
            '*.numeric'                 => 'This column is required to be filled in with number',
            '*.string'                  => 'This column is required to be filled in with letters',
        ];

        $this->validate([
            'siswa_id'      => ['required'],
            'riwayatkesehatan'      => ['required'],
            'keterangan'      => ['required']
        ], $messages);

        ModelsRiwayat::updateOrCreate(['id' => $this->riwayat_id], [
            'siswa_id'      => $this->siswa_id,
            'riwayat'      => $this->riwayatkesehatan,
            'keterangan'      => $this->keterangan,
        ]);

        $this->alert('success', $this->riwayat_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!');
        $this->resetForm();
        $this->dispatchBrowserEvent('storedData');
    }

    public function deleteId($id)
    {
        $this->deleteid = $id;
    }

    public function delete()
    {
        // dd($this->deleteid);
        ModelsRiwayat::where('id', $this->deleteid)->delete();

        $this->alert('success', 'Data berhasil dihapus!');
    }

    public function import()
    {
        // dd($this->template_excel);
        $file_path = $this->template_excel->store('files', 'public');
        //dd($file_path);
        Excel::import(new RiwayatSiswaImport, storage_path('/app/public/' . $file_path));
        Storage::disk('public')->delete($file_path);

        $this->resetForm();
        $this->alert('success', 'Data berhasil diimport!');
    }
}
