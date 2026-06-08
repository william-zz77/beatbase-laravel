<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model {
    protected $table      = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable   = ['id_reservasi','jumlah','metode_bayar','status_bayar','dibayar_at'];
    protected $casts      = ['jumlah' => 'decimal:2', 'dibayar_at' => 'datetime'];

    public function reservasi() { return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi'); }

    public function getStatusLabelAttribute(): string {
        return match($this->status_bayar) { 'lunas'=>'Lunas','refund'=>'Refund',default=>'Belum Bayar' };
    }
    public function getStatusBadgeAttribute(): string {
        return match($this->status_bayar) { 'lunas'=>'badge-lunas','refund'=>'badge-refund',default=>'badge-belum' };
    }
}