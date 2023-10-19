@section('title', 'Tambah Siswa PKL')
<div>
    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-md-4">
                            <input class="form-control" readonly value="{{ $ta->tahun_ajaran }}" />
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('siswa-pkl') }}"><button
                                    class="btn btn-sm btn-success">Kembali</button></a>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->hasRole(['admin', 'waka']))
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Guru</label>
                            <div class="col-md-4">
                                <select wire:model="user_id" class="form-control">
                                    <option value="">-- Pilih Nama Guru --</option>
                                    @foreach ($nama_guru as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Awal PKL</label>
                        <div class="col-md-4">
                            <input wire:model="awalpkl" type="date"
                                class="form-control @error('awalpkl') is-invalid @enderror" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Akhir PKL</label>
                        <div class="col-md-4">
                            <input wire:model="akhirpkl" type="date" class="form-control" required />
                        </div>
                    </div>
                </div>
                @if ($showJKD)
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jurusan</label>
                            <div class="col-md-10">
                                <select wire:model="jurusan" class="form-control">
                                    <option value="">-- Jurusan --</option>
                                    @foreach ($alljurusan as $jrs)
                                        <option value="{{ $jrs->id }}">{{ $jrs->kode_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">DUDI</label>
                            <div class="col-md-10">
                                <select wire:model="dudi" id="dudi_id" class="form-control">
                                    <option value="">-- DUDI PKL --</option>
                                    @if ($data_dudi)
                                        @foreach ($data_dudi as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama_dudi }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kelas</label>
                            <div class="col-md-10">
                                <select wire:model="kelas" id="kelas_id" class="form-control">
                                    <option value="">-- Kelas --</option>
                                    @if ($data_kelas)
                                        @foreach ($data_kelas as $kls)
                                            <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <hr>
            @if ($showSiswa)
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th width="150px">Aksi</th>
                            </tr>
                            @forelse ($data_siswa as $siswa)
                                <tr>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>
                                        <button wire:click.prevent="tambahSiswa({{ $siswa->id }})" type="button"
                                            class="btn btn-sm btn-success"><i class="fas fa-plus"></i>
                                            Tambahkan</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Semua Siswa Kelas ini telah memiliki tempat
                                        PKL</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('data_kelas', event => {
            console.log(event);
            // $.each(event.detail.data_kelas, function(i, item) {
            //     $('#kelas_id').append($('<option>', {
            //         value: item.id,
            //         text: item.nama_kelas
            //     }));
            // });
        })
        window.addEventListener('data_dudi', event => {
            console.log(event);
            // $.each(event.detail.data_dudi, function(i, item) {
            //     $('#dudi_id').append($('<option>', {
            //         value: item.id,
            //         text: item.nama_dudi
            //     }));
            // });
        })
    </script>
@endpush
