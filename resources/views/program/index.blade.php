<!DOCTYPE html>
<html>
<head>
    <title>Data Program</title>
</head>
<body>

<h2>Tambah Program</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="/program">
    @csrf
    <div>
        <label>Nama Program</label><br>
        <input type="text" name="nama_program">
    </div>

    <div>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi"></textarea>
    </div>

    <button type="submit">Simpan</button>
</form>

<hr>

<h2>List Program</h2>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Program</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($programs as $program)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $program->nama_program }}</td>
            <td>{{ $program->deskripsi }}</td>
            <td>
                <a href="{{ route('program.edit', $program->id) }}">
                    Edit
                </a>

                <form action="{{ route('program.destroy', $program->id) }}"
                      method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Yakin hapus program ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
