<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['nama_program', 'deskripsi'];

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }
}


