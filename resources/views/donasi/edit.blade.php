<!DOCTYPE html>
<html>
<head>
    <title>Edit Donasi</title>
</head>
<body>

<h2>Edit Donasi</h2>

@if($errors->any())
    <div style="color:red">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('donasi.update', $donasi->id) }}">
    @csrf
    @method('PUT')

    <label>Nama Donatur</label><br>
    <input type="text" name="nama_donatur"
           value="{{ old('nama_donatur', $donasi->donatur->nama ?? '') }}" required>
    <br><br>

    <label>Nominal</label><br>
    <input type="number" name="nominal"
           value="{{ old('nominal', $donasi->nominal) }}" required>
    <br><br>

    <button type="submit">💾 Save</button>

    <a href="{{ route('donasi.index') }}">
        <button type="button">⬅ Back</button>
    </a>

</form>

</body>
</html>
