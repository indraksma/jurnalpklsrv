@section('title', 'SISWA PKL')
<div>
    <div class="card card-primary">
        <div class="card-header">Data Siswa Bimbingan PKL</div>
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-sm-4">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Tahun Ajaran</label>
                        <div class="col-md-6">
                            <input class="form-control" readonly value="{{ $ta->tahun_ajaran }}" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    <a href="{{ route('siswa-pkl.tambah') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah
                        Siswa</a>
                </div>
            </div>
            <hr>
            <livewire:siswa-pkl-table />
        </div>
    </div>
</div>
