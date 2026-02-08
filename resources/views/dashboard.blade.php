<!DOCTYPE html>
<html>
<head>
    <title>Dashboard KRA</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin: 0;
            font-size: 14px;
            color: #777;
        }

        .card p {
            margin-top: 10px;
            font-size: 22px;
            font-weight: bold;
        }

        .donasi { color: #2e7d32; }
        .pengeluaran { color: #c62828; }
        .saldo { color: #1565c0; }
        .donatur { color: #6a1b9a; }

        h2 {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f0f2f5;
            font-size: 14px;
            text-transform: uppercase;
        }

        td strong {
            color: #1565c0;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .right {
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<h1>Dashboard Donasi Kartu IDAMAN 1447 H</h1>
<div class="subtitle">
    Transparansi & Laporan Keuangan Donasi Kampoeng Ramadhan Al-Jihad #5
</div>

<!-- SUMMARY CARDS -->
<div class="cards">
    <div class="card">
        <h3>Total Donasi</h3>
        <p class="donasi">
            Rp {{ number_format($totalDonasi,0,',','.') }}
        </p>
    </div>

    <div class="card">
        <h3>Total Pengeluaran</h3>
        <p class="pengeluaran">
            Rp {{ number_format($totalPengeluaran,0,',','.') }}
        </p>
    </div>

    <div class="card">
        <h3>Saldo Nasional</h3>
        <p class="saldo">
            Rp {{ number_format($saldoNasional,0,',','.') }}
        </p>
    </div>

    <div class="card">
        <h3>Total Donatur</h3>
        <p class="donatur">
            {{ number_format($totalDonatur) }} Orang
        </p>
    </div>
</div>

<!-- TABLE -->
<!-- TABLE -->
<h2>Ringkasan Pengeluaran per Program</h2>

<table>
    <thead>
        <tr>
            <th>Program</th>
            <th class="right">Total Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotalPengeluaran = 0; @endphp

        @foreach($ringkasanProgram as $row)
            @php
                $grandTotalPengeluaran += $row['pengeluaran'];
            @endphp
            <tr>
                <td>{{ $row['nama'] }}</td>
                <td class="right">
                    Rp {{ number_format($row['pengeluaran'],0,',','.') }}
                </td>
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th style="text-align:right;">TOTAL PENGELUARAN</th>
            <th class="right">
                <strong>
                    Rp {{ number_format($grandTotalPengeluaran,0,',','.') }}
                </strong>
            </th>
        </tr>
    </tfoot>
</table>

<h3 style="margin-top:40px;">Daftar Donatur</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Donatur</th>
            <th>Total Donasi</th>
            <th>Jumlah Transaksi</th>
            <th>Donasi Terakhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donaturList as $donatur)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $donatur->donatur->nama ?? 'Anonim' }}</td>
            <td>
                Rp {{ number_format($donatur->total_donasi,0,',','.') }}
            </td>
            <td>{{ $donatur->total_transaksi }}x</td>
            <td>
                {{ \Carbon\Carbon::parse($donatur->terakhir_donasi)->format('d-m-Y') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    © {{ date('Y') }} — Laporan Donasi Transparan
</div>

</body>
</html>
