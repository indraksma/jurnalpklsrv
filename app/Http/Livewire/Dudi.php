<?php

namespace App\Http\Livewire;

use App\Imports\DudiImport;
use Livewire\Component;
use App\Models\Dudi as ModelsDudi;
use App\Models\Jurusan;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class Dudi extends Component
{
    use WithPagination, WithFileUploads, LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['edit', 'delete'];

    public $dudi_id, $nama_dudi, $kabkota, $alamat, $jurusan_id;
    public $template_excel;
    public $iteration = 0;

    public function render()
    {
        $jurusan = Jurusan::all();
        $dudi = ModelsDudi::paginate(15);
        return view('livewire.dudi', [
            'dudi' => $dudi,
            'jurusan' => $jurusan,
        ])->extends('layouts.app');
    }

    public function resetForm()
    {
        $this->reset(['dudi_id', 'nama_dudi', 'kabkota', 'alamat', 'jurusan_id']);
        $this->iteration++;
        $this->resetErrorBag();
    }

    public function store()
    {
        $messages = [
            '*.required'                => 'This column is required',
            '*.numeric'                 => 'This column is required to be filled in with number',
            '*.string'                  => 'This column is required to be filled in with letters',
        ];

        $this->validate([
            'nama_dudi'      => ['required'],
            'alamat'      => ['required'],
            'jurusan_id'      => ['required'],
            'kabkota'      => ['required']
        ], $messages);

        ModelsDudi::updateOrCreate(['id' => $this->dudi_id], [
            'nama_dudi'      => $this->nama_dudi,
            'alamat'      => $this->alamat,
            'kab_kota'      => $this->kabkota,
            'jurusan_id'      => $this->jurusan_id,
        ]);

        $this->alert('success', $this->dudi_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!');
        $this->resetForm();

        $this->emit('refreshSiswaTable');
    }

    public function edit($id)
    {
        $dudi = ModelsDudi::findOrFail($id);

        $this->dudi_id = $id;
        $this->nama_dudi = $dudi->nama_dudi;
        $this->kabkota = $dudi->kab_kota;
        $this->alamat = $dudi->alamat;
        $this->jurusan_id = $dudi->jurusan_id;
    }

    public function import()
    {
        // dd($this->template_excel);
        $file_path = $this->template_excel->store('files', 'public');
        //dd($file_path);
        Excel::import(new DudiImport, storage_path('/app/public/' . $file_path));
        Storage::disk('public')->delete($file_path);

        $this->resetForm();
        $this->emit('refreshSiswaTable');
        $this->alert('success', 'Data berhasil diimport!');
    }

    public function delete($id)
    {
        $sql = ModelsDudi::where('id', $id)->firstOrFail();

        $sql->find($id)->delete();

        $this->emit('refreshSiswaTable');

        $this->alert('warning', 'Data berhasil dihapus!');
    }
}
