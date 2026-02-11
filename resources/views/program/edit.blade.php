<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Program</title>

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
        <h2 class="fw-bold mb-1">Edit Program</h2>
        <p class="text-muted">Perbarui informasi program</p>
    </div>

    <!-- ALERT ERROR -->
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM EDIT -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">
            Form Edit Program
        </div>
        <div class="card-body">

            <form action="{{ route('program.update', $program->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Program</label>
                        <input type="text"
                               name="nama_program"
                               class="form-control"
                               value="{{ old('nama_program', $program->nama_program) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Deskripsi singkat program">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('program.index') }}" class="btn btn-secondary px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- FOOTER -->
    <div class="text-center text-muted small mt-4">
        © {{ date('Y') }} — Modul Program
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
