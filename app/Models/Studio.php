<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model {
    protected $table      = 'studio';
    protected $primaryKey = 'id_studio';
    protected $fillable   = ['id_owner', 'nama_studio', 'deskripsi', 'harga_per_jam', 'is_active'];
    protected $casts      = ['harga_per_jam' => 'decimal:2', 'is_active' => 'boolean'];

    public function owner()    { return $this->belongsTo(User::class,     'id_owner',   'id_user'); }
    public function reservasi(){ return $this->hasMany(Reservasi::class,  'id_studio',  'id_studio'); }

    public function scopeAktif($query)              { return $query->where('is_active', true); }
    public function scopeMilikOwner($query, $id)    { return $query->where('id_owner', $id); }
}