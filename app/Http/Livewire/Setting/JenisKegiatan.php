<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\Jenis_kegiatan;

class JenisKegiatan extends Component
{
    use WithPagination, LivewireAlert;

    public $nama_kegiatan, $kode_kegiatan, $jk_id;

    public function render()
    {
        $jk = Jenis_kegiatan::all();
        return view('livewire.setting.jenis-kegiatan', ['jk' => $jk])->extends('layouts.app');
    }

    public function resetForm()
    {
        $this->reset(['jk_id', 'nama_kegiatan', 'kode_kegiatan']);
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
            'nama_kegiatan'      => ['required'],
            'kode_kegiatan'      => ['required']
        ], $messages);

        Jenis_kegiatan::updateOrCreate(['id' => $this->jk_id], [
            'nama_kegiatan'      => $this->nama_kegiatan,
            'kode_kegiatan'      => $this->kode_kegiatan,
        ]);

        $this->alert('success', $this->jk_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $jk = Jenis_kegiatan::findOrFail($id);

        $this->jk_id = $id;
        $this->nama_kegiatan = $jk->nama_kegiatan;
        $this->kode_kegiatan = $jk->kode_kegiatan;
    }

    public function delete($id)
    {
        $sql = Jenis_kegiatan::where('id', $id)->firstOrFail();

        $sql->find($id)->delete();

        $this->alert('warning', 'Data berhasil dihapus!');
    }

    public function activate($id)
    {
        Jenis_kegiatan::where('kunci', 1)->update(['kunci' => 0]);

        Jenis_kegiatan::where('id', $id)->update(['kunci' => 1]);
        $this->alert('success', 'Setting kunci entri nilai berhasil!');
    }
}
