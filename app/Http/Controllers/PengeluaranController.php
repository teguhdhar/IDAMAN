<?php

namespace App\Http\Controllers;
use App\Models\Pengeluaran;
use App\Models\Donasi;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index()
    {
        $programs = Program::all();

        $pengeluarans = Pengeluaran::with('program')->latest()->get();

        $pengeluaranPerProgram = Pengeluaran::select(
                'program_id',
                DB::raw('SUM(jumlah_pengeluaran) as total')
            )
            ->groupBy('program_id')
            ->with('program')
            ->get();

        $totalDonasi = Donasi::sum('nominal');
        $totalPengeluaran = Pengeluaran::sum('jumlah_pengeluaran');
        $saldoGlobal = $totalDonasi - $totalPengeluaran;

        return view('pengeluaran.index', compact(
            'programs',
            'pengeluarans',
            'pengeluaranPerProgram',
            'saldoGlobal'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required',
            'jumlah_pengeluaran' => 'required|numeric',
            'keterangan' => 'required',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        $saldoGlobal =
            Donasi::sum('nominal') -
            Pengeluaran::sum('jumlah_pengeluaran');

        if ($validated['jumlah_pengeluaran'] > $saldoGlobal) {
            return back()->withErrors([
                'jumlah_pengeluaran' =>
                    'Pengeluaran melebihi saldo global. Sisa saldo: Rp ' .
                    number_format($saldoGlobal, 0, ',', '.')
            ])->withInput();
        }

        Pengeluaran::create($validated);

        return redirect('/pengeluaran')
            ->with('success', 'Pengeluaran berhasil disimpan');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $programs = Program::all();

        return view('pengeluaran.edit', compact(
            'pengeluaran',
            'programs'
        ));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'program_id' => 'required',
            'jumlah_pengeluaran' => 'required|numeric',
            'keterangan' => 'required',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        $pengeluaranLama = Pengeluaran::findOrFail($id);

        $saldoGlobal =
            Donasi::sum('nominal') -
            (Pengeluaran::sum('jumlah_pengeluaran') - $pengeluaranLama->jumlah_pengeluaran);

        if ($validated['jumlah_pengeluaran'] > $saldoGlobal) {
            return back()->withErrors([
                'jumlah_pengeluaran' =>
                    'Pengeluaran melebihi saldo global. Sisa saldo: Rp ' .
                    number_format($saldoGlobal, 0, ',', '.')
            ])->withInput();
        }

        $pengeluaranLama->update($validated);

        return redirect('/pengeluaran')
            ->with('success', 'Pengeluaran berhasil diupdate');
    }

    public function destroy($id)
    {
        Pengeluaran::findOrFail($id)->delete();

        return redirect('/pengeluaran')
            ->with('success', 'Pengeluaran berhasil dihapus');
    }
}
