<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanJam extends Model {
    protected $table    = 'pengaturan_jam';
    protected $fillable = ['jam_buka', 'jam_tutup'];

    public static function getAktif(): self {
        return self::firstOrCreate([], ['jam_buka' => '09:00:00', 'jam_tutup' => '22:00:00']);
    }
}