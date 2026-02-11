<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengeluaran Program</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f8;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .table thead th {
            background-color: #f1f3f5;
            text-transform: uppercase;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">Pengeluaran Program</h2>
        <p class="text-muted">Input & Rekap Pengeluaran per Program</p>
    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ALERT ERROR -->
    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM INPUT -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">
            Input Pengeluaran
        </div>
        <div class="card-body">

            <form action="{{ route('pengeluaran.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Program</label>
                        <select name="program_id" class="form-select" required>
                            <option value="">-- Pilih Program --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">
                                    {{ $program->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Pengeluaran</label>
                        <input type="number" name="jumlah_pengeluaran" class="form-control" placeholder="Masukkan nominal" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Pembelian konsumsi buka puasa" required></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Pengeluaran</label>
                        <input type="date" name="tanggal_pengeluaran" class="form-control" required>
                    </div>

                    <div class="col-md-8 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            Simpan Pengeluaran
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- TABLE PENGELUARAN -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">
            Daftar Pengeluaran
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width:140px;">Tanggal</th>
                        <th>Program</th>
                        <th class="text-end" style="width:200px;">Jumlah</th>
                        <th>Keterangan</th>
                        <th style="width:150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengeluarans as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pengeluaran)->format('d-m-Y') }}</td>
                        <td>{{ $p->program->nama_program }}</td>
                        <td class="text-end fw-semibold text-danger">
                            Rp {{ number_format($p->jumlah_pengeluaran,0,',','.') }}
                        </td>
                        <td>{{ $p->keterangan }}</td>
                        <td class="text-center">

                            <a href="{{ route('pengeluaran.edit', $p->id) }}"
                               class="btn btn-sm btn-warning text-white">
                                Edit
                            </a>

                            <form action="{{ route('pengeluaran.destroy', $p->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus pengeluaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach

                    @if(count($pengeluarans) == 0)
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data pengeluaran.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <!-- TOTAL PENGELUARAN PER PROGRAM -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">
            Total Pengeluaran per Program
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th class="text-end" style="width:250px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengeluaranPerProgram as $row)
                    <tr>
                        <td>{{ $row->program->nama_program }}</td>
                        <td class="text-end fw-bold text-primary">
                            Rp {{ number_format($row->total,0,',','.') }}
                        </td>
                    </tr>
                    @endforeach

                    @if(count($pengeluaranPerProgram) == 0)
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">
                                Belum ada rekap pengeluaran per program.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="text-center text-muted small mt-4">
        © {{ date('Y') }} — Modul Pengeluaran Program
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
