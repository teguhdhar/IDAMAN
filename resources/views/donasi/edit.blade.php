<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Donasi</title>

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
        <h2 class="fw-bold mb-1">Edit Donasi</h2>
        <p class="text-muted">Perbarui data donasi yang sudah masuk</p>
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
            Form Edit Donasi
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('donasi.update', $donasi->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Donatur</label>
                        <input type="text"
                               name="nama_donatur"
                               class="form-control"
                               value="{{ old('nama_donatur', $donasi->donatur->nama ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nominal</label>
                        <input type="number"
                               name="nominal"
                               class="form-control"
                               value="{{ old('nominal', $donasi->nominal) }}"
                               required>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('donasi.index') }}" class="btn btn-secondary px-4">
                            Back
                        </a>

                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            Save
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- FOOTER -->
    <div class="text-center text-muted small mt-4">
        © {{ date('Y') }} — Modul Donasi Transparan
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
