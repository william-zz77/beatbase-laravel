<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studio';
    protected $primaryKey = 'id_studio';
    public $timestamps = false;

    protected $fillable = [
        'nama_studio',
        'harga_per_jam',
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_studio', 'id_studio');
    }
}