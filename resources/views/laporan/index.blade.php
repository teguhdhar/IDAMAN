<form action="{{ route('laporan.filter') }}" method="POST">
    @csrf

    <label>Program</label>
    <select name="program_id" required>
        <option value="">-- Pilih Program --</option>

        <option value="all">Semua Program</option>

        @foreach ($programs as $program)
            <option value="{{ $program->id }}">
                {{ $program->nama_program }}
            </option>
        @endforeach
    </select>

    <label>Dari</label>
    <input type="date" name="from" required>

    <label>Sampai</label>
    <input type="date" name="to" required>

    <button type="submit">
        Tampilkan Laporan
    </button>
</form>


