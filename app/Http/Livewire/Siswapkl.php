<?php

namespace App\Http\Livewire;

use App\Models\Siswa_pkl;
use App\Models\Tahun_ajaran;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Siswapkl extends Component
{
    use LivewireAlert;
    protected $listeners = ['edit', 'delete'];

    public function render()
    {
        $ta = Tahun_ajaran::where('aktif', 1)->first();
        return view('livewire.siswapkl', [
            'ta' => $ta,
        ])->extends('layouts.app');
    }

    public function delete($id)
    {
        $sql = Siswa_pkl::where('id', $id)->firstOrFail();

        $sql->find($id)->delete();

        $this->alert('warning', 'Data berhasil dihapus!');
        $this->emit('refreshSiswaPklTable');
    }
}
