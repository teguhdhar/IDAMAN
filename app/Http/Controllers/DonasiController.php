<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonasiController extends Controller
{
public function index()
{
    $totalDonasi = Donasi::sum('nominal');

    $donasis = Donasi::with('donatur')
        ->latest()
        ->get();
    $donasis = $donasis->sortBy('donatur_id');


    return view('donasi.index', compact(
        'totalDonasi',
        'donasis'
    ));

}

    public function store(Request $request)
    {
        $request->validate([
            'nama_donatur' => 'required',
            'email'        => 'nullable|email',
            'no_hp'        => 'nullable',
            'nominal'      => 'required|numeric',//min:1000
        ]);

        // ambil / buat donatur (hindari duplikasi)
        $donatur = Donatur::firstOrCreate(
            ['nama' => $request->nama_donatur],
            [
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ]
        );

        // simpan donasi
        Donasi::create([
        'donatur_id' => $donatur->id,
        'nominal'    => $request->nominal,
        'tanggal'    => now(),
    ]);

    return redirect('/donasi')->with('success', 'Donasi berhasil disimpan 🙏');
}
        public function edit($id)
        {
            $donasi = Donasi::with('donatur')->findOrFail($id);
            return view('donasi.edit', compact('donasi'));

        }


    public function update(Request $request, $id)
{
    $request->validate([
        'nama_donatur' => 'required',
        'email'        => 'nullable|email',
        'no_hp'        => 'nullable',
        'nominal'      => 'required|numeric', //min:1000
    ]);

    $donasi = Donasi::findOrFail($id);

    $donatur = Donatur::firstOrCreate(
        ['nama' => $request->nama_donatur],
        [
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]
    );

    $donasi->update([
        'donatur_id' => $donatur->id,
        'nominal'    => $request->nominal,
    ]);

    return redirect()->route('donasi.index')
        ->with('success', 'Donasi berhasil diupdate');
}


    public function destroy($id)
    {
        Donasi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Donasi dihapus');
    }

}
