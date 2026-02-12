<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donasi</title>

    @php
        $isPdf = request()->routeIs('laporan.donasi.pdf');
    @endphp

    {{-- Bootstrap hanya untuk halaman web --}}
    @if(!$isPdf)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @endif

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        @page {
            margin: 20mm;
        }

        /* =======================
           STYLE KHUSUS PDF
        ======================= */
        @if($isPdf)
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
        @endif
    </style>
</head>

<body class="{{ !$isPdf ? 'bg-light' : '' }}">

@if(!$isPdf)
    <div class="container py-4">

        {{-- HEADER WEB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Laporan Donasi</h4>
                <small class="text-muted">Kampoeng Ramadhan Al-Jihad #5</small>
            </div>

            <a href="{{ route('laporan.donasi.pdf', request()->only('from','to')) }}"
               target="_blank"
               class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
            </a>
        </div>

        {{-- FILTER --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.donasi') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Dari</label>
                            <input type="date" name="from" value="{{ $from }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sampai</label>
                            <input type="date" name="to" value="{{ $to }}" class="form-control">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i> Filter
                            </button>

                            <a href="{{ route('laporan.donasi') }}" class="btn btn-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- INFO PERIODE --}}
        <div class="alert alert-light border mb-4">
            <strong>Periode:</strong>
            @if($from && $to)
                {{ \Carbon\Carbon::parse($from)->format('d-m-Y') }}
                s/d
                {{ \Carbon\Carbon::parse($to)->format('d-m-Y') }}
            @else
                Semua Tanggal
            @endif
        </div>

        {{-- SUMMARY --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="mb-1 text-muted fw-semibold">Total Donasi</p>
                        <h4 class="fw-bold text-success mb-0">
                            Rp {{ number_format($totalDonasi,0,',','.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="mb-1 text-muted fw-semibold">Total Donatur</p>
                        <h4 class="fw-bold mb-0">
                            {{ $totalDonatur }} orang
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Donatur</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th width="130">Tanggal</th>
                                <th width="160">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donasis as $donasi)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $donasi->donatur->nama ?? '-' }}</td>
                                    <td>{{ $donasi->donatur->email ?? '-' }}</td>
                                    <td>{{ $donasi->donatur->no_hp ?? '-' }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($donasi->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-end fw-semibold text-success">
                                        Rp {{ number_format($donasi->nominal,0,',','.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Tidak ada data donasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-muted small mt-3">
                    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
                </div>
            </div>
        </div>

    </div>

@else
    {{-- =======================
         MODE PDF (JANGAN UBAH UI PDF)
    ======================= --}}

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
@endif

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donasi</title>

    @php
        $isPdf = request()->routeIs('laporan.donasi.pdf');
    @endphp

    {{-- Bootstrap hanya untuk halaman web --}}
    @if(!$isPdf)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @endif

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        @page {
            margin: 20mm;
        }

        /* =======================
           STYLE KHUSUS PDF
        ======================= */
        @if($isPdf)
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
        @endif
    </style>
</head>

<body class="{{ !$isPdf ? 'bg-light' : '' }}">

@if(!$isPdf)
    <div class="container py-4">

        {{-- HEADER WEB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Laporan Donasi</h4>
                <small class="text-muted">Kampoeng Ramadhan Al-Jihad #5</small>
            </div>

            <a href="{{ route('laporan.donasi.pdf', request()->only('from','to')) }}"
               target="_blank"
               class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
            </a>
        </div>

        {{-- FILTER --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.donasi') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Dari</label>
                            <input type="date" name="from" value="{{ $from }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sampai</label>
                            <input type="date" name="to" value="{{ $to }}" class="form-control">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i> Filter
                            </button>

                            <a href="{{ route('laporan.donasi') }}" class="btn btn-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- INFO PERIODE --}}
        <div class="alert alert-light border mb-4">
            <strong>Periode:</strong>
            @if($from && $to)
                {{ \Carbon\Carbon::parse($from)->format('d-m-Y') }}
                s/d
                {{ \Carbon\Carbon::parse($to)->format('d-m-Y') }}
            @else
                Semua Tanggal
            @endif
        </div>

        {{-- SUMMARY --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="mb-1 text-muted fw-semibold">Total Donasi</p>
                        <h4 class="fw-bold text-success mb-0">
                            Rp {{ number_format($totalDonasi,0,',','.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="mb-1 text-muted fw-semibold">Total Donatur</p>
                        <h4 class="fw-bold mb-0">
                            {{ $totalDonatur }} orang
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Donatur</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th width="130">Tanggal</th>
                                <th width="160">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donasis as $donasi)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $donasi->donatur->nama ?? '-' }}</td>
                                    <td>{{ $donasi->donatur->email ?? '-' }}</td>
                                    <td>{{ $donasi->donatur->no_hp ?? '-' }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($donasi->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-end fw-semibold text-success">
                                        Rp {{ number_format($donasi->nominal,0,',','.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Tidak ada data donasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-muted small mt-3">
                    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
                </div>
            </div>
        </div>

    </div>

@else
    {{-- =======================
         MODE PDF (JANGAN UBAH UI PDF)
    ======================= --}}

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
@endif

</body>
</html>
