<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    protected $fillable   = ['nama', 'email', 'password', 'role'];
    protected $hidden     = ['password', 'remember_token'];
    protected $casts      = ['password' => 'hashed'];

    // Role helpers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isOwner(): bool    { return $this->role === 'owner'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }

    // Relasi
    public function studio()    { return $this->hasMany(Studio::class,   'id_owner', 'id_user'); }
    public function reservasi() { return $this->hasMany(Reservasi::class, 'id_user',  'id_user'); }
}