<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlets';
    protected $fillable = [
        'nama_outlet',
        'alamat',
        'telepon',
        'foto',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function promo_outlets()
    {
        return $this->hasMany(PromoOutlet::class);
    }
    public function promos()
    {
        return $this->hasMany(PromoOutlet::class);
    }
}