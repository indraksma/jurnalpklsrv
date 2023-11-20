@section('title', 'Jurnal Pembelajaran PKL')
<div>
    @if (($cek_siswa == 0 || $cek_doc == 0) && !Auth::user()->hasRole('admin'))
        <div class="alert alert-warning">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            Anda belum menyelesaikan pengaturan bimbingan pkl, harap lakukan setting pada halaman berikut.<br>
            @if ($cek_siswa == 0)
                <a href="{{ route('siswa-pkl') }}"><button class="btn btn-sm btn-secondary">Setting Siswa PKL</button></a>
            @endif
            @if ($cek_doc == 0)
                <a href="{{ route('doc') }}"><button class="btn btn-sm btn-secondary">Setting Link
                        Dokumentasi</button></a>
            @endif
        </div>
    @else
        <div class="card card-secondary">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h5 class="mb-0">Data Jurnal Tahun Ajaran {{ $ta->tahun_ajaran }}</h5>
                    </div>
                    <div class="col-6 text-right"><a href="{{ route('jurnal.tambah') }}"><button
                                class="btn btn-sm btn-success">Tambah</button></a></div>
                </div>
            </div>
            <div class="card-body">
                @if (Auth::user()->hasRole(['admin', 'waka']))
                    <livewire:jurnal-table />
                @else
                    <div class="row">
                        <div class="col-md-9">
                            <h5>{{ Auth::user()->name }}</h5>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Search" wire:model="searchTerm" />
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>DUDI</th>
                                <th>Jenis Kegiatan</th>
                                <th>Dokumentasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$jurnal)
                                <tr>
                                    <td class="text-center" colspan="5">Belum ada data</td>
                                </tr>
                            @else
                                @foreach ($jurnal as $item)
                                    <tr>
                                        <td>{{ date_format(date_create($item->tanggal), 'j F Y') }}</td>
                                        <td>{{ $item->nama_dudi }}</td>
                                        <td>{{ $item->nama_kegiatan }}</td>
                                        <td><a href="{{ $item->link_dokumentasi }}" target="_blank"><button
                                                    class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>&nbsp;
                                                    Lihat</button></a></td>
                                        <td>
                                            <a href="{{ route('jurnal.edit', ['idjurnal' => $item->id]) }}"><button
                                                    class="btn btn-sm btn-info"><i class="fas fa-edit"></i>
                                                    Edit</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($jurnal)
                        {{ $jurnal->links() }}
                    @endif
                @endif
            </div>
        </div>
    @endif
    <!-- Modal -->
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
</div>
