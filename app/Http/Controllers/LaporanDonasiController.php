<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donasi;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanDonasiController extends Controller
{
    public function index(Request $request)
{
    $from = $request->from;
    $to   = $request->to;

    $donasis = Donasi::with('donatur')
        ->when($from && $to, function ($q) use ($from, $to) {
            $q->whereBetween('tanggal', [$from, $to]);
        })
        ->orderBy('tanggal', 'desc')
        ->get();

    $totalDonasi = $donasis->sum('nominal');
    $totalDonatur = $donasis->pluck('donatur_id')->unique()->count();

    return view('laporan.donasi', compact(
        'donasis',
        'totalDonasi',
        'totalDonatur',
        'from',
        'to'
    ));
}


       public function pdf(Request $request)
{
    $from = $request->from;
    $to   = $request->to;

    $donasis = Donasi::with('donatur')
        ->when($from && $to, function ($q) use ($from, $to) {
            $q->whereBetween('tanggal', [$from, $to]);
        })
        ->orderBy('tanggal', 'desc')
        ->get();

    $totalDonasi = $donasis->sum('nominal');
    $totalDonatur = $donasis->pluck('donatur_id')->unique()->count();

    $pdf = Pdf::loadView('laporan.donasi', compact(
        'donasis',
        'totalDonasi',
        'totalDonatur',
        'from',
        'to'
    ))->setPaper('A4', 'portrait');

    return $pdf->stream(
        'laporan-donasi.pdf',
        ['Content-Disposition' => 'inline']
    );
}


}
