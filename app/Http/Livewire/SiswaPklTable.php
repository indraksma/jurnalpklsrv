<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Siswa_pkl;
use App\Models\Tahun_ajaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaPklTable extends DataTableComponent
{
    protected $listeners = ['refreshSiswaPklTable' => '$refresh'];
    protected $model = Siswa_pkl::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['siswa_pkls.id']);
    }

    public function columns(): array
    {
        if (Auth::user()->hasRole(['admin', 'waka'])) {
            return [
                Column::make("Nama Siswa", "siswa.nama")
                    ->searchable()
                    ->sortable(),
                Column::make("Kelas", "siswa.kelas.nama_kelas")
                    ->searchable()
                    ->sortable(),
                Column::make("DUDI", "dudi.nama_dudi")
                    ->searchable()
                    ->sortable(),
                Column::make("Pembimbing", "user.name")
                    ->searchable()
                    ->sortable(),
                Column::make("Tgl Mulai PKL", "awal_pkl")
                    ->searchable()
                    ->sortable()
                    ->format(function ($value) {
                        return Carbon::parse($value)->isoFormat('D MMMM Y');;
                    }),
                Column::make("Tgl Selesai PKL", "akhir_pkl")
                    ->searchable()
                    ->sortable()
                    ->format(function ($value) {
                        return Carbon::parse($value)->isoFormat('D MMMM Y');;
                    }),
                Column::make('Actions')
                    ->label(function ($row, Column $column) {
                        return view('livewire.action.delete-siswapkl', ['data' => $row]);
                    })->hideIf(!auth()->user()->hasRole('admin')),
            ];
        } else {
            return [
                Column::make("Nama Siswa", "siswa.nama")
                    ->searchable()
                    ->sortable(),
                Column::make("Kelas", "siswa.kelas.nama_kelas")
                    ->searchable()
                    ->sortable(),
                Column::make("DUDI", "dudi.nama_dudi")
                    ->searchable()
                    ->sortable(),
                Column::make("Tgl Mulai PKL", "awal_pkl")
                    ->searchable()
                    ->sortable()
                    ->format(function ($value) {
                        return Carbon::parse($value)->isoFormat('D MMMM Y');;
                    }),
                Column::make("Tgl Selesai PKL", "akhir_pkl")
                    ->searchable()
                    ->sortable()
                    ->format(function ($value) {
                        return Carbon::parse($value)->isoFormat('D MMMM Y');;
                    }),
                Column::make('Actions')
                    ->label(function ($row, Column $column) {
                        return view('livewire.action.delete-siswapkl', ['data' => $row]);
                    }),
            ];
        }
    }

    public function builder(): Builder
    {
        $ta_id = Tahun_ajaran::where('aktif', 1)->pluck('id');
        if (Auth::user()->hasRole(['admin', 'waka'])) {
            return Siswa_pkl::query()
                ->where('siswa_pkls.tahun_ajaran_id', $ta_id)
                ->orderBy('siswas.kelas_id')->orderBy('siswas.nis');
        } else {
            return Siswa_pkl::query()
                ->where('siswa_pkls.user_id', Auth::user()->id)
                ->where('siswa_pkls.tahun_ajaran_id', $ta_id);
        }
    }
}
