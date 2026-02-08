<!DOCTYPE html>
<html>
<head>
    <title>Donasi</title>
</head>
<body>
<h2>Ringkasan Donasi</h2>

<p>
    <strong>Total Donasi Keseluruhan:</strong>
    Rp {{ number_format($totalDonasi) }}
</p>

{{-- <h3>Total Donasi per Program</h3>

<ul>
    @foreach($donasiPerProgram as $item)
        <li>
            {{ $item->program->nama_program }} :
            Rp {{ number_format($item->total) }}
        </li>
    @endforeach
</ul> --}}

<hr>

{{-- <h2>Saldo Program</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Program</th>
        <th>Donasi</th>
        <th>Pengeluaran</th>
        {{-- <th>Saldo</th> --}}
    {{-- </tr>

    @foreach($saldoPerProgram as $item)
        <tr>
            <td>{{ $item['nama'] }}</td>
            <td>{{ number_format($item['donasi']) }}</td>
            <td>{{ number_format($item['pengeluaran']) }}</td>
            {{-- <td><strong>{{ number_format($item['saldo']) }}</strong></td> --}}
        {{-- </tr>
    @endforeach
</table>  --}}


<h2>Form Donasi</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('donasi.store') }}">
@csrf

<label>Nama Donatur</label>
<input type="text" name="nama_donatur" required>

<label>Email</label>
<input type="email" name="email">

<label>No HP</label>
<input type="text" name="no_hp">

<label>Nominal</label>
<input type="number" name="nominal" required>

<button type="submit">Simpan Donasi</button>
</form>

<hr>

<table border="1">
<tr>
    <th>No</th>
    <th>Donatur</th>
    <th>Nominal</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>

@foreach($donasis as $donasi)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $donasi->donatur->nama }}</td>
    <td>Rp {{ number_format($donasi->nominal) }}</td>
    <td>{{ $donasi->tanggal }}</td>
    <td>
        <a href="{{ route('donasi.edit', $donasi->id) }}">Edit</a>
        <form action="{{ route('donasi.destroy', $donasi->id) }}"
              method="POST"
              style="display:inline"
              onsubmit="return confirm('Yakin hapus donasi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>


</body>
</html>
