<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengeluaran</title>
</head>
<body>

<h3>Edit Pengeluaran</h3>

@if($errors->any())
    <div style="color:red">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengeluaran.update', $pengeluaran->id) }}"
      method="POST">
    @csrf
    @method('PUT')

    <label>Program</label><br>
    <select name="program_id" required>
        @foreach($programs as $program)
            <option value="{{ $program->id }}"
                {{ $program->id == $pengeluaran->program_id ? 'selected' : '' }}>
                {{ $program->nama_program }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Jumlah Pengeluaran</label><br>
    <input type="number"
           name="jumlah_pengeluaran"
           value="{{ old('jumlah_pengeluaran', $pengeluaran->jumlah_pengeluaran) }}"
           required>
    <br><br>

    <label>Keterangan</label><br>
    <textarea name="keterangan" required>{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
    <br><br>

    <label>Tanggal Pengeluaran</label><br>
    <input type="date"
           name="tanggal_pengeluaran"
           value="{{ old('tanggal_pengeluaran', $pengeluaran->tanggal_pengeluaran) }}"
           required>
    <br><br>

    <button type="submit">Update</button>
    <a href="/pengeluaran">Batal</a>
</form>

</body>
</html>
