<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'program_id',
        'jumlah_pengeluaran',
        'keterangan',
        'tanggal_pengeluaran'
    ];

    // ✅ PENGELUARAN MILIK 1 PROGRAM
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
