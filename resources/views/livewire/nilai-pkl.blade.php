@section('title', 'Nilai PKL')
<div>
    <form wire:submit.prevent="store()">
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Entri Nilai PKL</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tahun Ajaran</label>
                            <div class="col-md-4">
                                <input class="form-control" readonly value="{{ $ta->tahun_ajaran }}" />
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->hasRole(['admin', 'waka']))
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Nama Guru Penilai</label>
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
                </div>
                <hr>
                @if ($showWarning)
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                        Anda belum melakukan pengisian jurnal kegiatan Ujian / Penilaian. Harap isikan jurnal penilaian
                        sebelum melakukan entri nilai!
                    </div>
                @endif
                @if ($showSiswa)
                    <div class="row">
                        @if ($penilai)
                            <div class="col-md-12">
                                <h4>Telah dinilai oleh {{ $penilai }}</h4>
                            </div>
                        @endif
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th width="10%">Nilai</th>
                                    <th>Catatan</th>
                                </tr>
                                @forelse ($data_siswa as $key => $siswa)
                                    <tr>
                                        <td>{{ $siswa->siswa->nama }}</td>
                                        <td>{{ $siswa->siswa->nis }}</td>
                                        <td>{{ $siswa->siswa->kelas->nama_kelas }}</td>
                                        <td><input class="form-control" type="number"
                                                wire:model.lazy="nilai.{{ $key }}" required /></td>
                                        <td>
                                            <input class="form-control" type="text"
                                                wire:model.lazy="catatan.{{ $key }}" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
