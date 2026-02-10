<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pengaduan</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background: #f3f3f3;
        }

        .small {
            font-size: 11px;
        }

        .section {
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Pengaduan</h2>
        <div class="small">Periode: {{ $dari ?? 'Semua' }} - {{ $sampai ?? 'Semua' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Aduan</th>
                <th>Tanggal Lapor</th>
                <th>Pelapor</th>
                <th>Status</th>
                <th>Kategori</th>
                <th>OPD</th>
                <th>Unit OPD (riwayat)</th>
                <th>Tanggapan</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $r->no_aduan ?? '' }}</td>
                <td>{{ optional($r->tanggal_lapor)->format('Y-m-d') ?? '' }}</td>
                <td>{{ $r->masyarakat?->pengguna?->nama_pengguna ?? $r->masyarakat?->nama_lengkap ?? '' }}</td>
                <td>{{ $r->statusAduan?->nama_status ?? '' }}</td>
                <td>{{ $r->kategoriAduan?->nama_kategori ?? '' }}</td>
                <td>
                    @if($r->kategoriAduan && $r->kategoriAduan->opd)
                    @foreach($r->kategoriAduan->opd as $opd)
                    {{ $opd->nama_opd ?? $opd->nama }}@if(!$loop->last), @endif
                    @endforeach
                    @endif
                </td>
                <td>
                    @if($r->riwayatStatus && $r->riwayatStatus->count())
                    @foreach($r->riwayatStatus as $rw)
                    {{ $rw->unitOpd?->nama_unit ?? '-' }} ({{ optional($rw->waktu_status_aduan)->format('Y-m-d') ?? '' }})@if(!$loop->last) / @endif
                    @endforeach
                    @else
                    -
                    @endif
                </td>
                <td class="small">
                    @if($r->tanggapan && $r->tanggapan->count())
                    @foreach($r->tanggapan as $t)
                    {{ $t->keterangan }} @if(!$loop->last) \n @endif
                    @endforeach
                    @else
                    -
                    @endif
                </td>
                <td>{{ $r->lokasi ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section small">Di-generate: {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</div>
</body>

</html>