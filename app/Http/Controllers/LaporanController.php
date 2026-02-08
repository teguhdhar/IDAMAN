<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\Pengeluaran;

class LaporanController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('laporan.index', compact('programs'));
    }

    // =========================
    // PREVIEW HTML
    // =========================


public function program(Request $request, $id)
{
    $from = $request->from;
    $to   = $request->to;

    // =========================
    // SEMUA PROGRAM
    // =========================
    if ($id === 'all') {

        $programs = Program::with([
            'pengeluarans' => function ($q) use ($from, $to) {
                if ($from && $to) {
                    $q->whereBetween('tanggal_pengeluaran', [$from, $to]);
                }
            }
        ])->get();

        $donasiQuery = Donasi::query();
        if ($from && $to) {
            $donasiQuery->whereBetween('tanggal', [$from, $to]);
        }

        $totalDonasi = $donasiQuery->sum('nominal');
        $totalPengeluaran = $programs
            ->flatMap->pengeluarans
            ->sum('jumlah_pengeluaran');

        return view('laporan.program', [
            'programs' => $programs,
            'totalDonasi' => $totalDonasi,
            'totalPengeluaran' => $totalPengeluaran,
            'from' => $from,
            'to' => $to,
            'mode' => 'all'
        ]);
    }

    // =========================
    // SINGLE PROGRAM
    // =========================
   $program = Program::findOrFail($id);

$totalDonasi = Donasi::when($from && $to, function ($q) use ($from, $to) {
    $q->whereBetween('tanggal', [$from, $to]);
})->sum('nominal');

$totalPengeluaran = Pengeluaran::where('program_id', $program->id)
    ->when($from && $to, function ($q) use ($from, $to) {
        $q->whereBetween('tanggal_pengeluaran', [$from, $to]);
    })
    ->sum('jumlah_pengeluaran');

$grandPengeluaran = Pengeluaran::when($from && $to, function ($q) use ($from, $to) {
    $q->whereBetween('tanggal_pengeluaran', [$from, $to]);
})->sum('jumlah_pengeluaran');

$saldoGlobal = $totalDonasi - $grandPengeluaran;

return view('laporan.program', compact(
    'program',
    'totalDonasi',
    'totalPengeluaran',
    'grandPengeluaran',
    'saldoGlobal',
    'from',
    'to'
) + ['mode' => 'single']);


}

    // =========================
    // PDF PREVIEW (INLINE)
    // =========================
    public function programPdf(Request $request, $id)
{
    $from = $request->from;
    $to   = $request->to;

    // =========================
    // SEMUA PROGRAM (PDF)
    // =========================
    if ($id === 'all') {

        $programs = Program::with([
            'pengeluarans' => function ($q) use ($from, $to) {
                if ($from && $to) {
                    $q->whereBetween('tanggal_pengeluaran', [$from, $to]);
                }
            }
        ])->get();

        $donasiQuery = Donasi::query();
        if ($from && $to) {
            $donasiQuery->whereBetween('tanggal', [$from, $to]);
        }

        $totalDonasi = $donasiQuery->sum('nominal');
        $totalPengeluaran = $programs
            ->flatMap->pengeluarans
            ->sum('jumlah_pengeluaran');

        $pdf = Pdf::loadView('laporan.program', [
            'programs' => $programs,
            'totalDonasi' => $totalDonasi,
            'totalPengeluaran' => $totalPengeluaran,
            'from' => $from,
            'to' => $to,
            'mode' => 'all'
        ])->setPaper('A4', 'portrait');

        return $pdf->stream(
            'laporan-semua-program.pdf',
            ['Content-Disposition' => 'inline']
        );
    }

        // =========================
        // SINGLE PROGRAM (PDF)
        // =========================
        $program = Program::findOrFail($id);

$totalDonasi = Donasi::when($from && $to, function ($q) use ($from, $to) {
    $q->whereBetween('tanggal', [$from, $to]);
})->sum('nominal');

$totalPengeluaran = Pengeluaran::where('program_id', $program->id)
    ->when($from && $to, function ($q) use ($from, $to) {
        $q->whereBetween('tanggal_pengeluaran', [$from, $to]);
    })
    ->sum('jumlah_pengeluaran');

$grandPengeluaran = Pengeluaran::when($from && $to, function ($q) use ($from, $to) {
    $q->whereBetween('tanggal_pengeluaran', [$from, $to]);
})->sum('jumlah_pengeluaran');

$saldoGlobal = $totalDonasi - $grandPengeluaran;

$pdf = Pdf::loadView('laporan.program', compact(
    'program',
    'totalDonasi',
    'totalPengeluaran',
    'grandPengeluaran',
    'saldoGlobal',
    'from',
    'to'
) + ['mode' => 'single'])
->setPaper('A4', 'portrait');

return $pdf->stream(
    'laporan-' . $program->nama_program . '.pdf',
    ['Content-Disposition' => 'inline']
);


}
    public function filter(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'from' => 'nullable|date',
            'to'   => 'nullable|date|after_or_equal:from',
        ]);

        return redirect()->route('laporan.program', [
            'id' => $request->program_id === 'all'
                ? 'all'
                : $request->program_id,
            'from' => $request->from,
            'to' => $request->to,
        ]);
    }
}
