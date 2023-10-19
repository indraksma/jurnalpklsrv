<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi Jurnal Pembelajaran PKL SMKN 1 Bawang">
    <meta name="author" content="IndraKus @indrakus_">
    <link rel="icon" type="image" href="{{ asset('favicon.png') }}">
    <title>Laporan Siswa PKL - SIJUPRAK</title>
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
    <h3 class="ctr">DAFTAR SISWA<br>PRAKTIK KERJA LAPANGAN<br>SMK NEGERI 1 BAWANG</h3>
    <h4 class="ctr">KELAS {{ $kelas->nama_kelas }} TAHUN PELAJARAN
        {{ $kelas->tahun_ajaran->tahun_ajaran }}</h4>
    <table border="1" class="coba ctr" width="100%" cellspacing="0" style="margin-bottom: 50px;">
        <tr style="font-weight: bold;">
            <td width="5%">No.</td>
            <td width="25%">Nama</td>
            <td width="15%">NIS</td>
            <td width="30%">DUDI</td>
            <td width="25%">Pembimbing</td>
        </tr>
        <?php
        $no = 1;
        ?>
        @foreach ($siswa as $key => $data)
            <tr>
                <td class="ctr">{{ $no }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->nis }}</td>
                @if ($data->siswapkl)
                    <td>{{ $data->siswapkl->dudi->nama_dudi }}</td>
                    <td>{{ $data->siswapkl->user->name }}</td>
                @else
                    <td>-</td>
                    <td>-</td>
                @endif
            </tr>
            <?php
            $no++;
            ?>
        @endforeach
    </table>
    <table width="100%" style="margin-top: 20px;" class="ctr">
        <td width="50%">
            &nbsp;
        </td>
        <td width="50%"><br>
            Mengetahui,<br>
            Kepala Sekolah
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $kelas->tahun_ajaran->user->name }}<br>
            NIP. {{ $kelas->tahun_ajaran->user->nip }}
        </td>
    </table>
</body>

</html>
