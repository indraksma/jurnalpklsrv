@section('title', 'Tujuan Pembelajaran')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Data Tujuan Pembelajaran</h3>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Tujuan Pembelajaran</th>
                            <th style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tp as $item)
                            <tr>
                                <td>{{ $item->tahun_ajaran->tahun_ajaran }}</td>
                                <td>{{ $item->tujuan_pembelajaran }}</td>
                                <td>
                                    <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-info"><i
                                            class="fas fa-edit"></i></button>&nbsp;
                                    <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger"
                                        onclick="confirm('Are you sure to delete?') || event.stopImmediatePropagation()"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-sm-12 col-md-12">
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{ $tp->links() }}
                    </div>
                </div>
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
                        <select wire:model="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}"
                            class="form-control @error('tahun_ajaran') is-invalid @enderror" required="required">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($ta as $datata)
                                <option value="{{ $datata->id }}">{{ $datata->tahun_ajaran }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-calendar"></span>
                            </div>
                        </div>
                    </div>
                    @error('tahun_ajaran')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="input-group mb-3">
                        <input wire:model.lazy="tujuan_pembelajaran" value="{{ old('tujuan_pembelajaran') }}"
                            class="form-control @error('tujuan_pembelajaran') is-invalid @enderror"
                            placeholder="Tujuan Pembelajaran" required="required">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-list"></span>
                            </div>
                        </div>
                    </div>
                    @error('tujuan_pembelajaran')
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
    <script>
        window.addEventListener('editFocus', event => {
            const element = document.getElementById("tahun_ajaran");
            element.scrollIntoView();
        })
    </script>
</div>
