@section('title', 'Jenis Kegiatan')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Data Jenis Kegiatan</h3>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode Kegiatan</th>
                            <th>Nama Kegiatan</th>
                            <th>Kunci Entri Nilai</th>
                            <th style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jk as $item)
                            <tr>
                                <td>{{ $item->kode_kegiatan }}</td>
                                <td>{{ $item->nama_kegiatan }}</td>
                                <td>
                                    @if ($item->kunci == 1)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->kunci != 1)
                                        <button class="btn btn-sm btn-success"
                                            wire:click="activate({{ $item->id }})"><i
                                                class="fas fa-key"></i></button>
                                    @endif
                                    <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-info"><i
                                            class="fas fa-edit"></i></button>
                                    <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger"
                                        onclick="confirm('Are you sure to delete?') || event.stopImmediatePropagation()"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah / Ubah Data</h4>
            </div>
            <form method="POST" wire:submit.prevent="store()">
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input wire:model="kode_kegiatan" id="kode_kegiatan" type="text" name="kode_kegiatan"
                            value="{{ old('kode_kegiatan') }}"
                            class="form-control @error('kode_kegiatan') is-invalid @enderror"
                            placeholder="Kode Kegiatan" required="required">
                    </div>
                    @error('kode_kegiatan')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="input-group mb-3">
                        <input wire:model="nama_kegiatan" id="nama_kegiatan" type="text" name="nama_kegiatan"
                            value="{{ old('nama_kegiatan') }}"
                            class="form-control @error('nama_kegiatan') is-invalid @enderror"
                            placeholder="Nama Kegiatan" required="required">
                    </div>
                    @error('nama_kegiatan')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" wire:click="resetForm()" class="btn btn-warning">Reset</button>
                    <button type="button" wire:click.prevent="store()" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
