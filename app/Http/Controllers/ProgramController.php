<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get();

        $saldoPerProgram = Program::withSum('pengeluarans', 'jumlah_pengeluaran')
            ->get()
            ->map(function ($program) {
                return [
                    'nama_program' => $program->nama_program,
                    'total_pengeluaran' =>
                        $program->pengeluarans_sum_jumlah_pengeluaran ?? 0,
                ];
            });

        return view('program.index', compact(
            'programs',
            'saldoPerProgram'
        ));
    }
    public function store(Request $request)
{
    $request->validate([
        'nama_program' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
    ]);

    Program::create([
        'nama_program' => $request->nama_program,
        'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('program.index')
        ->with('success', 'Program berhasil ditambahkan');
}


    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required',
            'deskripsi' => 'nullable',
        ]);

        $program = Program::findOrFail($id);
        $program->update($request->all());

        return redirect()->route('program.index')
            ->with('success', 'Program berhasil diupdate');
    }

    public function destroy($id)
    {
        $program = Program::withCount('pengeluarans')->findOrFail($id);

        if ($program->pengeluarans_count > 0) {
            return redirect()->back()
                ->with('error', 'Program masih memiliki pengeluaran');
        }

        $program->delete();

        return redirect()->route('program.index')
            ->with('success', 'Program berhasil dihapus');
    }
}
