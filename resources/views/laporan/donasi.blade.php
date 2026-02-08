<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
        @page {
    margin: 20mm;
}

    </style>
</head>
<body>
@if(!request()->routeIs('laporan.donasi.pdf'))
<form method="GET" action="{{ route('laporan.donasi') }}"
      style="margin-bottom:15px; text-align:center;">
    Dari:
    <input type="date" name="from" value="{{ $from }}">
    Sampai:
    <input type="date" name="to" value="{{ $to }}">

    <button type="submit">Filter</button>
</form>
@endif



    @php
    $isPdf = request()->routeIs('laporan.donasi.pdf');
@endphp

@if(!request()->routeIs('laporan.donasi.pdf'))
    <a href="{{ route('laporan.donasi.pdf', request()->only('from','to')) }}"
       target="_blank">
       Cetak PDF
    </a>
@endif



<h2>LAPORAN DONASI</h2>
<h3>KAMPOENG RAMADHAN AL-JIHAD #5</h3>

<p style="text-align:center;">
    Periode:
    @if($from && $to)
        {{ \Carbon\Carbon::parse($from)->format('d-m-Y') }}
        –
        {{ \Carbon\Carbon::parse($to)->format('d-m-Y') }}
    @else
        Semua Tanggal
    @endif
</p>

<hr>

<p><strong>Total Donasi:</strong>
    Rp {{ number_format($totalDonasi,0,',','.') }}
</p>

<p><strong>Total Donatur:</strong>
    {{ $totalDonatur }} orang
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Donatur</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Tanggal</th>
            <th class="right">Nominal</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($donasis as $donasi)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $donasi->donatur->nama ?? '-' }}</td>
            <td>{{ $donasi->donatur->email ?? '-' }}</td>
            <td>{{ $donasi->donatur->no_hp ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d-m-Y') }}</td>
            <td class="right">
                Rp {{ number_format($donasi->nominal,0,',','.') }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">
                Tidak ada data donasi
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<hr>

<p style="font-size:11px;">
    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
</p>

</body>
</html>
