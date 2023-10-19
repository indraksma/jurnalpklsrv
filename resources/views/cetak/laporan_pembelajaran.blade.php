<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi Jurnal Pembelajaran PKL SMKN 1 Bawang">
    <meta name="author" content="IndraKus @indrakus_">
    <link rel="icon" type="image" href="{{ asset('favicon.png') }}">
    <title>Laporan Kegiatan Pembelajaran PKL - SIJUPRAK</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .coba td {
            padding-top: 7px;
            padding-bottom: 7px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .topik td {
            padding-top: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
            padding-right: 0px;
            font-size: 10px;
            text-align: left;
            vertical-align: top;
        }

        .ctr {
            text-align: center;
        }
    </style>
</head>

<body>
    <h3 class="ctr">JURNAL PEMBELAJARAN<br>PRAKTIK KERJA LAPANGAN<br>SMK NEGERI 1 BAWANG</h3>
    <h4 class="ctr">Bulan {{ \Carbon\Carbon::createFromDate(2023, $bulan)->isoFormat('MMMM') }} Tahun Pelajaran
        {{ $jurnal->tahun_ajaran->tahun_ajaran }}</h4>
    <table style="margin-bottom: 20px;">
        <tr>
            <td width="150px">Nama Siswa</td>
            <td width="10px">:</td>
            <td>{{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td width="150px">Kelas</td>
            <td width="10px">:</td>
            <td>{{ $siswa->kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td width="150px">NIS</td>
            <td width="10px">:</td>
            <td>{{ $siswa->nis }}</td>
        </tr>
        <tr>
            <td width="150px">DUDI</td>
            <td width="10px">:</td>
            <td>{{ $jurnal->dudi->nama_dudi }}</td>
        </tr>
        <tr>
            <td width="150px">Pembimbing</td>
            <td width="10px">:</td>
            <td>{{ $jurnal->user->name }}</td>
        </tr>
    </table>
    <table border="1" class="coba ctr" width="100%" cellspacing="0" style="margin-bottom: 50px;">
        <tr style="font-weight: bold;">
            <td width="5%">No.</td>
            <td width="10%">Hari/Tanggal</td>
            <td width="10%">Jenis Kegiatan</td>
            <td width="20%">Materi</td>
            <td width="10%">Kehadiran</td>
            <td width="25%">Link Dokumentasi</td>
            <td width="20%">Keterangan</td>
        </tr>
        <?php
        $no = 1;
        ?>
        @foreach ($jurnal_all as $key => $data)
            <tr>
                <td class="ctr">{{ $no }}</td>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->isoFormat('dddd / D-M-Y') }}</td>
                <td>{{ $data->jenis_kegiatan->nama_kegiatan }}</td>
                <td>{{ $data->materi }}</td>
                <td>{{ $data->kehadiran }}</td>
                <td>{{ $data->link_dokumentasi }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
            <?php
            $no++;
            ?>
        @endforeach
    </table>
    <table width="100%" style="margin-top: 20px;" class="ctr">
        <td width="50%"><br>
            Mengetahui,<br>
            Kepala Sekolah
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $jurnal->tahun_ajaran->user->name }}<br>
            NIP. {{ $jurnal->tahun_ajaran->user->nip }}
        </td>
        <td>
            Banjarnegara, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
            <br>
            Guru Pembimbing
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $jurnal->user->name }}<br>
            NIP. <?php if ($jurnal->user->nip == null) {
                echo '-';
            } else {
                echo $jurnal->user->nip;
            } ?>
        </td>
    </table>
</body>

</html>
