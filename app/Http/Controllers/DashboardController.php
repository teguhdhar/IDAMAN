<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Donasi;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // GLOBAL
        // =========================
        $totalDonasi = Donasi::sum('nominal');
        $totalPengeluaran = Pengeluaran::sum('jumlah_pengeluaran');
        $saldoNasional = $totalDonasi - $totalPengeluaran;

        $totalDonatur = Donasi::whereNotNull('donatur_id')
            ->distinct('donatur_id')
            ->count('donatur_id');

        // =========================
        // RINGKASAN PER PROGRAM
        // =========================
        $programs = Program::withSum('pengeluarans', 'jumlah_pengeluaran')->get();

        $ringkasanProgram = $programs->map(function ($program) {
            $pengeluaran = $program->pengeluarans_sum_jumlah_pengeluaran ?? 0;

            return [
                'nama' => $program->nama_program,
                'donasi' => 0, // memang tidak ada relasi
                'pengeluaran' => $pengeluaran,
                'saldo' => -$pengeluaran
            ];
        });

        // =========================
        // DETAIL DONATUR
        // =========================
        $donaturList = Donasi::select(
                'donatur_id',
                DB::raw('SUM(nominal) as total_donasi'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('MAX(tanggal) as terakhir_donasi')
            )
            ->with('donatur')
            ->groupBy('donatur_id')
            ->orderByDesc('total_donasi')
            ->get();
        $donaturList = $donaturList->sortBy('donatur_id');

        return view('dashboard', compact(
            'totalDonasi',
            'totalPengeluaran',
            'saldoNasional',
            'totalDonatur',
            'ringkasanProgram',
            'donaturList'
        ));
    }
}
