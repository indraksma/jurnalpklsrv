@section('title', 'Laporan')
<div>
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">Laporan Jurnal PKL</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-md-4">
                            <select class="form-control" wire:model="ta_id">
                                @foreach ($tahun_ajaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jenis Laporan</label>
                        <div class="col-md-4">
                            <select class="form-control" wire:model="jenis_laporan">
                                <option value="">-- Pilih Jenis Laporan --</option>
                                <option value="1">Laporan Siswa PKL</option>
                                <option value="2">Laporan Pembelajaran PKL</option>
                            </select>
                        </div>
                    </div>
                </div>
                @if ($laporan_type == 1)
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jurusan</label>
                            <div class="col-md-4">
                                <select class="form-control" wire:model="jurusan_id">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($list_jurusan as $jrs)
                                        <option value="{{ $jrs->id }}">{{ $jrs->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kelas</label>
                            <div class="col-md-4">
                                <select class="form-control" wire:model="kelas_id">
                                    <option value="">-- Pilih Kelas --</option>
                                    @if ($list_kelas)
                                        @foreach ($list_kelas as $kelas)
                                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                @elseif ($laporan_type == 2)
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Guru</label>
                            <div class="col-md-4">
                                @if (Auth::user()->hasRole(['admin', 'waka']))
                                    <select class="form-control" wire:model="user_id">
                                        <option value="">-- Pilih Nama Guru --</option>
                                        @foreach ($nama_guru as $guru)
                                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" wire:model="user_id">
                                    <input type="text" class="form-control" wire:model="guru" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama DUDI</label>
                            <div class="col-md-4">
                                <select class="form-control" wire:model="dudi_id">
                                    <option value="">-- Pilih DUDI --</option>
                                    @if ($dudi)
                                        @foreach ($dudi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_dudi }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Bulan</label>
                            <div class="col-md-4">
                                <select class="form-control" wire:model="bulan">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Mei</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($showPrintBtn)
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-6 text-center">
                                <button class="btn btn-info" wire:click="cetakLaporan1"><i class="fas fa-print"></i>
                                    Unduh</button>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($showSiswa)
                    <hr />
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>NIS</th>
                                    <th style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $item)
                                    <tr>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                        <td>{{ $item->siswa->nis }}</td>
                                        <td>
                                            <a target="_blank" class="btn btn-sm btn-info text-white"
                                                wire:click="cetakLaporan2({{ $item->siswa->id }})"><i
                                                    class="fas fa-print"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
