<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Models\Dudi;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;

class DudiTable extends DataTableComponent
{
    protected $listeners = ['refreshSiswaTable' => '$refresh'];
    protected $model = Dudi::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['dudis.id']);
    }

    public function columns(): array
    {

        if (Auth::user()->hasRole(['admin', 'waka', 'pokja'])) {
            return [
                Column::make("Nama DUDI", "nama_dudi")
                    ->searchable()
                    ->sortable(),
                Column::make("Jurusan", "jurusan.kode_jurusan")
                    ->searchable()
                    ->sortable(),
                Column::make("Kab/Kota", "kab_kota")
                    ->searchable()
                    ->sortable(),
                Column::make("Alamat", "Alamat")
                    ->searchable(),
                Column::make('Actions')
                    ->label(function ($row, Column $column) {
                        return view('livewire.action.edit-delete', ['data' => $row]);
                    }),
            ];
        } else {
            return [
                Column::make("Nama DUDI", "nama_dudi")
                    ->searchable()
                    ->sortable(),
                Column::make("Jurusan", "jurusan.kode_jurusan")
                    ->searchable()
                    ->sortable(),
                Column::make("Kab/Kota", "kab_kota")
                    ->searchable()
                    ->sortable(),
                Column::make("Alamat", "Alamat")
                    ->searchable(),
            ];
        }
    }
}
