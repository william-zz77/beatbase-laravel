<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model {
    protected $table      = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    protected $fillable   = ['id_user','id_studio','tanggal','jam_mulai','jam_selesai','total_harga','status','catatan'];
    protected $casts      = ['tanggal' => 'date', 'total_harga' => 'decimal:2'];

    public function user()      { return $this->belongsTo(User::class,      'id_user',      'id_user'); }
    public function studio()    { return $this->belongsTo(Studio::class,    'id_studio',    'id_studio'); }
    public function pembayaran(){ return $this->hasOne(Pembayaran::class,   'id_reservasi', 'id_reservasi'); }

    public function getDurasiJamAttribute(): float {
        return Carbon::parse($this->jam_mulai)->diffInMinutes(Carbon::parse($this->jam_selesai)) / 60;
    }
    public function getStatusLabelAttribute(): string {
        return match($this->status) { 'confirmed'=>'Dikonfirmasi','cancelled'=>'Dibatalkan',default=>'Menunggu' };
    }
    public function getStatusBadgeAttribute(): string {
        return match($this->status) { 'confirmed'=>'badge-confirmed','cancelled'=>'badge-cancelled',default=>'badge-pending' };
    }
}