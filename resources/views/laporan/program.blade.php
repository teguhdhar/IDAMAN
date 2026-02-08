<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        h4 {
            margin-top: 25px;
            margin-bottom: 8px;
        }
        p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f0f0f0;
        }
        .right {
            text-align: right;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>

@php
    // Jika route PDF → jangan tampilkan tombol
    $isPdf = request()->routeIs('laporan.program.pdf');
    $mode = $mode ?? 'single';
@endphp

{{-- ================= DOWNLOAD BUTTON (HTML ONLY) ================= --}}
@if(!$isPdf)
    <p style="text-align:center;">
        <a href="{{ route('laporan.program.pdf', [
            'id' => $mode === 'all' ? 'all' : $program->id,
            'from' => request('from'),
            'to' => request('to'),
        ]) }}" target="_blank">
            Download PDF
        </a>
    </p>
@endif

{{-- ================= HEADER ================= --}}
<h2>LAPORAN KEUANGAN</h2>
<h3>KAMPOENG RAMADHAN AL-JIHAD #5</h3>

<p style="text-align:center;">
    Periode:
    @if(!empty($from) && !empty($to))
        {{ \Carbon\Carbon::parse($from)->translatedFormat('d F Y') }}
        –
        {{ \Carbon\Carbon::parse($to)->translatedFormat('d F Y') }}
    @else
        Semua Tanggal
    @endif
</p>

<hr>

{{-- ================================================= --}}
{{-- ================= MODE SEMUA PROGRAM ============== --}}
{{-- ================================================= --}}
@if($mode === 'all')

<h3 style="text-align:center;">REKAP SEMUA PROGRAM</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Program</th>
            {{-- <th class="right">Donasi</th> --}}
            <th class="right">Pengeluaran</th>
            {{-- <th class="right">Saldo</th> --}}
        </tr>
    </thead>
    <tbody>
       @php
    $grandPengeluaran = 0;
@endphp

@foreach($programs as $i => $program)
@php
    $pengeluaran = $program->pengeluarans->sum('jumlah_pengeluaran');
    $grandPengeluaran += $pengeluaran;

    // saldo program = donasi global - pengeluaran program
    $saldoProgram = $totalDonasi - $pengeluaran;
@endphp
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $program->nama_program }}</td>
    <td class="right">
        Rp {{ number_format($pengeluaran,0,',','.') }}
    </td>
</tr>
@endforeach


    </tbody>
  <tfoot>
<tr>
    <th colspan="2">TOTAL PENGELUARAN</th>
    <th class="right">
        Rp {{ number_format($grandPengeluaran,0,',','.') }}
    </th>
</tr>
</tfoot>

</table>
<hr>

<p><strong>Total Donasi Global:</strong>
    Rp {{ number_format($totalDonasi,0,',','.') }}
</p>

<p><strong>Total Pengeluaran Semua Program:</strong>
    Rp {{ number_format($grandPengeluaran,0,',','.') }}
</p>

<p><strong>Sisa Saldo Global:</strong>
    Rp {{ number_format($totalDonasi - $grandPengeluaran,0,',','.') }}
</p>


{{-- ================================================= --}}
{{-- ================= MODE SINGLE PROGRAM ============= --}}
{{-- ================================================= --}}
@else

<h3>{{ $program->nama_program }}</h3>
<p style="text-align:center;">{{ $program->deskripsi }}</p>

<p><strong>Total Donasi Global (Periode Ini):</strong>
    Rp {{ number_format($totalDonasi,0,',','.') }}
</p>

<p><strong>Total Pengeluaran Program Ini:</strong>
    Rp {{ number_format($totalPengeluaran,0,',','.') }}
</p>

<p><strong>Total Pengeluaran Semua Program:</strong>
    Rp {{ number_format($grandPengeluaran,0,',','.') }}
</p>

<p><strong>Sisa Saldo Global:</strong>
    Rp {{ number_format($totalDonasi - $grandPengeluaran,0,',','.') }}
</p>


<br>

<h4>Daftar Pengeluaran</h4>
<table>
    <tr>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th class="right">Nominal</th>
    </tr>
    @foreach($program->pengeluarans as $p)
    <tr>
        <td>{{ $p->tanggal_pengeluaran }}</td>
        <td>{{ $p->keterangan }}</td>
        <td class="right">Rp {{ number_format($p->jumlah_pengeluaran,0,',','.') }}</td>
    </tr>
    @endforeach
</table>

@endif

<hr>

<p style="font-size:11px;">
    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
</p>

</body>
</html>
