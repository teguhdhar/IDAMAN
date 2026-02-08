<!DOCTYPE html>
<html>
<head>
    <title>Pengeluaran Program</title>
</head>
<body>

<h2>Input Pengeluaran</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengeluaran.store') }}" method="POST">

    @csrf

    <label>Program</label><br>
    <select name="program_id" required>
        <option value="">-- Pilih Program --</option>
        @foreach($programs as $program)
            <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
        @endforeach
    </select>
    <br><br>

    <label>Jumlah Pengeluaran</label><br>
    <input type="number" name="jumlah_pengeluaran" required>
    <br><br>

    <label>Keterangan</label><br>
    <textarea name="keterangan" required></textarea>
    <br><br>

    <label>Tanggal Pengeluaran</label><br>
    <input type="date" name="tanggal_pengeluaran" required>
    <br><br>

    <button type="submit">Simpan</button>
</form>

<hr>


<h2>Daftar Pengeluaran</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Tanggal</th>
        <th>Program</th>
        <th>Jumlah Pengeluaran</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    @foreach($pengeluarans as $p)
    <tr>
        <td>{{ $p->tanggal_pengeluaran }}</td>
        <td>{{ $p->program->nama_program }}</td>
        <td>Rp {{ number_format($p->jumlah_pengeluaran,0,',','.') }}</td>
        <td>{{ $p->keterangan }}</td>
        <td>
            <a href="{{ route('pengeluaran.edit', $p->id) }}">
                Edit
            </a>

            <form action="{{ route('pengeluaran.destroy', $p->id) }}"
                  method="POST"
                  style="display:inline"
                  onsubmit="return confirm('Yakin hapus pengeluaran ini?')">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>


<hr>


<h2>Total Pengeluaran per Program</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Program</th>
        <th>Total</th>
    </tr>

    @foreach($pengeluaranPerProgram as $row)
    <tr>
        <td>{{ $row->program->nama_program }}</td>
        <td>Rp {{ number_format($row->total,0,',','.') }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
