@section('title', 'Tambah Jurnal PKL')
<div>
    <div class="card card-primary">
        <div class="card-body">
            <form method="POST" wire:submit.prevent="store()">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal</label>
                            <div class="col-md-4">
                                @if (Auth::user()->hasRole('admin'))
                                    <input class="form-control" wire:model="tanggal" type="date" />
                                @else
                                    <input class="form-control" wire:model="tanggal" type="date" readonly />
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('jurnal') }}" class="btn btn-sm btn-success">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Guru</label>
                            <div class="col-md-10">
                                @if (Auth::user()->hasRole(['admin', 'waka']))
                                    <select wire:model="user" id="user_id"
                                        class="form-control @error('user') is-invalid @enderror">
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach ($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input wire:model="user" class="form-control" type="hidden" />
                                    <input type="text" class="form-control" readonly value="{{ $users->name }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis Kegiatan</label>
                            <div class="col-md-10">
                                <select wire:model="jeniskeg" id="jenis_id"
                                    class="form-control  @error('jeniskeg') is-invalid @enderror">
                                    <option value="">-- Jenis Kegiatan --</option>
                                    @foreach ($jk as $jkeg)
                                        <option value="{{ $jkeg->id }}">{{ $jkeg->nama_kegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">DUDI</label>
                            <div class="col-md-10">
                                <select wire:model="dudi" id="dudi_id"
                                    class="form-control  @error('dudi') is-invalid @enderror">
                                    <option value="">-- DUDI PKL --</option>
                                    @if ($dudi_list)
                                        @forelse($dudi_list as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama_dudi }}</option>
                                        @empty
                                            <option>Tidak Ada Data</option>
                                        @endforelse
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Link Dokumentasi</label>
                            <div class="col-md-10">
                                <input class="form-control  @error('link_dokumentasi') is-invalid @enderror"
                                    wire:model="link_dokumentasi" placeholder="Link Google Drive" />
                            </div>
                        </div>
                    </div> --}}
                </div>
                <hr>
                @if ($showSiswa)
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>NIS</th>
                                        <th>Materi</th>
                                        <th>Kehadiran</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    @forelse ($siswa as $key => $siswas)
                                        <input wire:model="siswaid.{{ $key }}" type="hidden" />
                                        <tr>
                                            <td>{{ $siswas->siswa->nama }}</td>
                                            <td>{{ $siswas->siswa->kelas->nama_kelas }}</td>
                                            <td>{{ $siswas->siswa->nis }}</td>
                                            <td>
                                                <textarea wire:model.lazy="materi.{{ $key }}"
                                                    class="form-control @error('materi.' . $key) is-invalid @enderror" required></textarea>
                                            </td>
                                            <td>
                                                <select wire:model="kehadiran.{{ $key }}"
                                                    class="form-control  @error('kehadiran.' . $key) is-invalid @enderror"
                                                    required>
                                                    <option value="">-- Presensi --</option>
                                                    <option value="H">Hadir</option>
                                                    <option value="I">Izin</option>
                                                    <option value="S">Sakit</option>
                                                    <option value="A">Alpha</option>
                                                </select>
                                            </td>
                                            <td>
                                                <textarea wire:model.lazy="keterangan.{{ $key }}"
                                                    class="form-control @error('keterangan.' . $key) is-invalid @enderror"></textarea>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data yang dapat ditampilkan
                                            </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                @endif
            </form>
        </div>
    </div>
</div>
