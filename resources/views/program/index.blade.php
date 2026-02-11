<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Program</title>

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
        <h2 class="fw-bold mb-1">Data Program</h2>
        <p class="text-muted">Kelola daftar program Kampoeng Ramadhan</p>
    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- FORM TAMBAH PROGRAM -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">
            Tambah Program
        </div>
        <div class="card-body">

            <form method="POST" action="/program">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Program</label>
                        <input type="text" name="nama_program" class="form-control"
                               placeholder="Contoh: Santunan Anak Yatim" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2"
                                  placeholder="Deskripsi singkat program"></textarea>
                    </div>

                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            Simpan Program
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- TABLE LIST PROGRAM -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">
            List Program
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width:70px;">No</th>
                        <th>Nama Program</th>
                        <th>Deskripsi</th>
                        <th style="width:160px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $program)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $program->nama_program }}</td>
                        <td>{{ $program->deskripsi }}</td>
                        <td class="text-center">

                            <a href="{{ route('program.edit', $program->id) }}"
                               class="btn btn-sm btn-warning text-white">
                                Edit
                            </a>

                            <form action="{{ route('program.destroy', $program->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus program ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach

                    @if(count($programs) == 0)
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada program.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
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
