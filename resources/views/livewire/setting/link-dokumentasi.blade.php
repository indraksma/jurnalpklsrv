@section('title', 'Link Dokumentasi')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="{{ $disableinput == false ? 'col-6' : 'col-12' }}">
                        <h3 class="card-title">Data Link Dokumentasi</h3>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <th>Link Dokumentasi</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($linkdok as $item)
                                <tr>
                                    <td>{{ $item->tahun_ajaran->tahun_ajaran }}</td>
                                    <td>{{ $item->link_dokumentasi }}</td>
                                    <td>
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
                            {{ $linkdok->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if ($disableinput == false)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data</h4>
                </div>
                <form method="POST" wire:submit.prevent="store()">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            @if (Auth::user()->hasRole(['admin', 'waka']))
                                <select wire:model="tahun_ajaran_id" id="tahun_ajaran_id" name="tahun_ajaran_id"
                                    value="{{ old('tahun_ajaran_id') }}"
                                    class="form-control @error('tahun_ajaran_id') is-invalid @enderror"
                                    required="required">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach ($tahun_ajaran as $ta)
                                        <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" id="tahun_ajaran_id" class="form-control"
                                    value="{{ $tahun_ajaran->tahun_ajaran }}" readonly />
                            @endif
                        </div>
                        @error('tahun_ajaran_id')
                            <div class="alert alert-danger">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="input-group mb-3">
                            <input wire:model.lazy="link_dokumentasi" id="link_dokumentasi" type="text"
                                name="link_dokumentasi" value="{{ old('link_dokumentasi') }}"
                                class="form-control @error('link_dokumentasi') is-invalid @enderror"
                                placeholder="Link Dokumentasi" required="required">
                        </div>
                        @error('link_dokumentasi')
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
    @endif
</div>
