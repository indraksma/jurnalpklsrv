<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Tahun_ajaran;
use App\Models\TujuanPembelajaran as ModelsTujuanPembelajaran;

class TujuanPembelajaran extends Component
{
    use WithPagination, LivewireAlert;
    public $tahun_ajaran, $tujuan_pembelajaran, $tp_id;

    public function render()
    {
        $ta = Tahun_ajaran::all();
        $tp = ModelsTujuanPembelajaran::paginate(10);
        return view('livewire.setting.tujuan-pembelajaran', [
            'ta' => $ta,
            'tp' => $tp,
        ])->extends('layouts.app');
    }

    public function resetForm()
    {
        $this->reset(['tp_id', 'tahun_ajaran', 'tujuan_pembelajaran']);
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
            'tahun_ajaran'      => ['required'],
            'tujuan_pembelajaran'      => ['required'],
        ], $messages);

        ModelsTujuanPembelajaran::updateOrCreate(['id' => $this->tp_id], [
            'tahun_ajaran_id'      => $this->tahun_ajaran,
            'tujuan_pembelajaran'      => $this->tujuan_pembelajaran,
        ]);

        $this->alert('success', $this->tp_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $tp = ModelsTujuanPembelajaran::findOrFail($id);

        $this->tahun_ajaran = $tp->tahun_ajaran_id;
        $this->tujuan_pembelajaran = $tp->tujuan_pembelajaran;
        $this->tp_id = $id;
        $this->dispatchBrowserEvent('editFocus');
    }

    public function delete($id)
    {
        $sql = ModelsTujuanPembelajaran::where('id', $id)->firstOrFail();

        $sql->find($id)->delete();

        $this->alert('warning', 'Data berhasil dihapus!');
    }
}
