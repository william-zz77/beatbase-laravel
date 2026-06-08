<?php
namespace Database\Seeders;

use App\Models\PengaturanJam;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $admin = User::create(['nama'=>'Administrator',  'email'=>'admin@beatbase.com',    'password'=>Hash::make('password'), 'role'=>'admin']);
        $owner = User::create(['nama'=>'Owner Studio',   'email'=>'owner@beatbase.com',    'password'=>Hash::make('password'), 'role'=>'owner']);
               User::create(['nama'=>'Customer Test',  'email'=>'customer@beatbase.com', 'password'=>Hash::make('password'), 'role'=>'customer']);

        Studio::create(['id_owner'=>$owner->id_user, 'nama_studio'=>'Studio A - Rock Room',    'deskripsi'=>'Studio akustik terbaik untuk rock & metal.', 'harga_per_jam'=>75000]);
        Studio::create(['id_owner'=>$owner->id_user, 'nama_studio'=>'Studio B - Jazz Lounge',  'deskripsi'=>'Suasana elegan untuk jazz dan akustik.',     'harga_per_jam'=>85000]);
        Studio::create(['id_owner'=>$owner->id_user, 'nama_studio'=>'Studio C - Premium Suite','deskripsi'=>'Studio rekaman profesional terlengkap.',      'harga_per_jam'=>120000]);

        PengaturanJam::create(['jam_buka'=>'09:00:00', 'jam_tutup'=>'22:00:00']);

        $this->command->info('Seeder selesai! Login: admin/owner/customer@beatbase.com | pass: password');
    }
}