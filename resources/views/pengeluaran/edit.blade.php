<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengeluaran</title>

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
    </style>
</head>
<body>

<div class="container py-4">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">Edit Pengeluaran</h2>
        <p class="text-muted">Perbarui data pengeluaran program</p>
    </div>

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

    <!-- FORM EDIT -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">
            Form Edit Pengeluaran
        </div>
        <div class="card-body">

            <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Program</label>
                        <select name="program_id" class="form-select" required>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ $program->id == $pengeluaran->program_id ? 'selected' : '' }}>
                                    {{ $program->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Pengeluaran</label>
                        <input type="number"
                               name="jumlah_pengeluaran"
                               class="form-control"
                               value="{{ old('jumlah_pengeluaran', $pengeluaran->jumlah_pengeluaran) }}"
                               required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control"
                                  rows="3"
                                  required>{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Pengeluaran</label>
                        <input type="date"
                               name="tanggal_pengeluaran"
                               class="form-control"
                               value="{{ old('tanggal_pengeluaran', $pengeluaran->tanggal_pengeluaran) }}"
                               required>
                    </div>

                    <div class="col-md-8 d-flex align-items-end justify-content-end gap-2">
                        <a href="/pengeluaran" class="btn btn-secondary px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            Update
                        </button>
                    </div>

                </div>
            </form>

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
