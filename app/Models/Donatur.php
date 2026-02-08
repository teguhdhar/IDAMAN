<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_hp'
    ];

    public function donasis()
    {
        return $this->hasMany(Donasi::class);
    }

}
