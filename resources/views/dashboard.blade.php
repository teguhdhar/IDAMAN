<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard KRA</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f6f7fb;
        }

        .dashboard-title {
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #6c757d;
        }

        .card-summary {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
            transition: all 0.2s ease-in-out;
        }

        .card-summary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.10);
        }

        .summary-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
        }

        .table-container {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
            overflow: hidden;
            background: white;
        }

        .table thead th {
            background: #f1f3f6 !important;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #495057;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .footer {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="container py-4">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h1 class="dashboard-title mb-2">
            Dashboard Donasi Kartu IDAMAN 1447 H
        </h1>
        <p class="subtitle mb-0">
            Transparansi & Laporan Keuangan Donasi Kampoeng Ramadhan Al-Jihad #5
        </p>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="row g-4 mb-4">

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-summary p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="summary-icon bg-success">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Donasi</div>
                        <div class="fw-bold fs-5 text-success">
                            Rp {{ number_format($totalDonasi,0,',','.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-summary p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="summary-icon bg-danger">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Pengeluaran</div>
                        <div class="fw-bold fs-5 text-danger">
                            Rp {{ number_format($totalPengeluaran,0,',','.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-summary p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="summary-icon bg-primary">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Sisa Saldo</div>
                        <div class="fw-bold fs-5 text-primary">
                            Rp {{ number_format($saldoNasional,0,',','.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-summary p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="summary-icon" style="background:#6f42c1;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Donatur</div>
                        <div class="fw-bold fs-5" style="color:#6f42c1;">
                            {{ number_format($totalDonatur) }} Orang
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RINGKASAN PROGRAM -->
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-bar-chart-fill text-primary"></i>
            Ringkasan Pengeluaran per Program
        </h4>
    </div>

    <div class="table-container mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th class="text-end">Total Pengeluaran</th>
                    </tr>
                </thead>

                <tbody>
                    @php $grandTotalPengeluaran = 0; @endphp

                    @foreach($ringkasanProgram as $row)
                        @php
                            $grandTotalPengeluaran += $row['pengeluaran'];
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $row['nama'] }}</td>
                            <td class="text-end text-danger fw-semibold">
                                Rp {{ number_format($row['pengeluaran'],0,',','.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="table-light">
                        <th class="text-end fw-bold">TOTAL PENGELUARAN</th>
                        <th class="text-end fw-bold text-danger">
                            Rp {{ number_format($grandTotalPengeluaran,0,',','.') }}
                        </th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

    <!-- DAFTAR DONATUR -->
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-heart-fill text-danger"></i>
            Daftar Donatur
        </h4>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
            Total: {{ number_format(count($donaturList)) }} Donatur
        </span>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:70px;">No</th>
                        <th>Nama Donatur</th>
                        <th>Total Donasi</th>
                        <th class="text-center">Jumlah Transaksi</th>
                        <th>Donasi Terakhir</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($donaturList as $donatur)
                    <tr>
                        <td class="fw-semibold">{{ $loop->iteration }}</td>

                        <td class="fw-semibold">
                            <i class="bi bi-person-circle text-secondary me-1"></i>
                            {{ $donatur->donatur->nama ?? 'Anonim' }}
                        </td>

                        <td class="fw-bold text-success">
                            Rp {{ number_format($donatur->total_donasi,0,',','.') }}
                        </td>

                        <td class="text-center">
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                {{ $donatur->total_transaksi }}x
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ \Carbon\Carbon::parse($donatur->terakhir_donasi)->format('d-m-Y') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="text-center mt-4 footer">
        © {{ date('Y') }} — Laporan Donasi Transparan
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
