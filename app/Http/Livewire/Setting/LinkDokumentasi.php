<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use App\Models\Tahun_ajaran;
use App\Models\LinkDokumentasi as ModelLD;
use Illuminate\Support\Facades\Auth;

class LinkDokumentasi extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $link_doc_id, $link_dokumentasi, $user_id, $tahun_ajaran_id;

    public function render()
    {
        $linkdok = ModelLD::where('user_id', Auth::user()->id)->paginate('5');
        $cekdata = ModelLD::select('tahun_ajaran_id')->where('user_id', Auth::user()->id)->get();
        if ($cekdata->isEmpty()) {
            $tahun_ajaran = Tahun_ajaran::all();
        } else {
            $tahun_ajaran = Tahun_ajaran::whereNotIn('id', $cekdata)->get();
        }
        return view('livewire.setting.link-dokumentasi', [
            'tahun_ajaran' => $tahun_ajaran,
            'linkdok' => $linkdok,
        ])->extends('layouts.app');
    }

    public function resetForm()
    {
        $this->reset(['link_doc_id', 'link_dokumentasi', 'user_id', 'tahun_ajaran_id']);
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
            'link_dokumentasi'      => ['required'],
            'tahun_ajaran_id'      => ['required']
        ], $messages);

        ModelLD::updateOrCreate(['id' => $this->link_doc_id], [
            'link_dokumentasi'      => $this->link_dokumentasi,
            'tahun_ajaran_id'      => $this->tahun_ajaran_id,
            'user_id'      => Auth::user()->id,
        ]);

        $this->alert('success', $this->link_doc_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $ld = ModelLD::findOrFail($id);

        $this->link_doc_id = $id;
        $this->link_dokumentasi = $ld->link_dokumentasi;
        $this->tahun_ajaran_id = $ld->tahun_ajaran_id;
    }

    public function delete($id)
    {
        $sql = ModelLD::where('id', $id)->firstOrFail();

        $sql->find($id)->delete();

        $this->alert('warning', 'Data berhasil dihapus!');
    }
}
