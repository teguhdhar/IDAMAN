<!DOCTYPE html>
<html>
<head>
    <title>Edit Program</title>
</head>
<body>

<h3>Edit Program</h3>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('program.update', $program->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Nama Program</label><br>
        <input type="text"
               name="nama_program"
               value="{{ old('nama_program', $program->nama_program) }}"
               required>
    </div>

    <br>

    <div>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
    </div>

    <br>

    <button type="submit">Simpan Perubahan</button>
    <a href="{{ route('program.index') }}">Batal</a>
</form>

</body>
</html>
