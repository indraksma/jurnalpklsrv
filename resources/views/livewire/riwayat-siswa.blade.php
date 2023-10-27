@section('title', 'Riwayat Siswa')
<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3 class="mb-0">Data Riwayat Siswa</h3>
                </div>
                @if (Auth::user()->hasRole(['admin', 'waka', 'pokja']))
                    <div class="col-6 text-right">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-success btn-sm" wire:click="createModal"
                                    data-toggle="modal" data-target="#createModal">Tambah</button>&nbsp;
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input class="form-control" type="file" wire:model="template_excel"
                                                id="upload{{ $iteration }}">
                                        </div>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info btn-sm"
                                                wire:click="import">Import</button>
                                        </div>
                                    </div>
                                    <a href="{{ asset('format_import_riwayat_siswa.xlsx') }}">Download format
                                        import</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>NIS</th>
                        <th>Riwayat</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($riwayat->isEmpty())
                        <tr>
                            <td class="text-center" colspan="6">Belum ada data</td>
                        </tr>
                    @else
                        @foreach ($riwayat as $item)
                            <tr>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                <td>{{ $item->siswa->nis }}</td>
                                <td>{{ $item->riwayat }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" wire:click="editModal({{ $item->id }})"
                                        data-toggle="modal" data-target="#createModal"><i class="fas fa-edit"></i>
                                        Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="deleteId({{ $item->id }})"
                                        data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i>
                                        Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if ($riwayat->isNotEmpty())
                {{ $riwayat->links() }}
            @endif
        </div>
    </div>
    {{-- Modal Siswa --}}
    <div wire:ignore.self class="modal fade" id="createModal" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Siswa</h4>
                    <button type="button" class="close" wire:click="closeModal" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <select wire:model="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                                id="jurusan" {{ $editdata ? 'disabled' : '' }}>
                                <option value="">-- Pilih Jurusan --</option>
                                @if ($jrs)
                                    @foreach ($jrs as $datajrs)
                                        <option value="{{ $datajrs->id }}">{{ $datajrs->nama_jurusan }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select wire:model="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror"
                                id="kelas" {{ $editdata ? 'disabled' : '' }}>
                                <option value="">-- Pilih Kelas --</option>
                                @if ($kls)
                                    @foreach ($kls as $datakls)
                                        <option value="{{ $datakls->id }}">{{ $datakls->nama_kelas }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="namaSiswa">Nama Siswa</label>
                            <select type="text" wire:model="siswa_id"
                                class="form-control @error('siswa_id') is-invalid @enderror" id="namaSiswa"
                                {{ $editdata ? 'disabled' : '' }}>
                                <option value="">-- Pilih Siswa --</option>
                                @if ($siswa)
                                    @foreach ($siswa as $datasiswa)
                                        <option value="{{ $datasiswa->id }}">{{ $datasiswa->nama }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="riwayat">Riwayat Kesehatan</label>
                            <input type="text" wire:model.lazy="riwayatkesehatan"
                                class="form-control @error('riwayatkesehatan') is-invalid @enderror" id="riwayat"
                                placeholder="Riwayat Kesehatan">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" wire:model.lazy="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                placeholder="Keterangan">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" wire:click="closeModal" class="btn btn-default"
                            data-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="store()" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- Modal Hapus -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal"
                        data-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('storedData', event => {
            $('#createModal').modal('hide');
        })
    </script>
</div>
