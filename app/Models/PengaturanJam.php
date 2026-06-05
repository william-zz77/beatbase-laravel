<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanJam extends Model
{
    protected $table = 'pengaturan_jam';
    public $timestamps = false;

    protected $fillable = [
        'jam_buka',
        'jam_tutup',
    ];
}