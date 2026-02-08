<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $fillable = [
        'donatur_id',
        'program_id',
        'nominal',
        'tanggal'
    ];

    public function donatur()
    {
        return $this->belongsTo(Donatur::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
