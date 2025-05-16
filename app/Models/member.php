<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'nama',
        'user_id',
        'telepon',
        'alamat',
        'saldo',
        'outlet_id',
        'midtrans_order_id',
        'midtrans_payment_status',
    ];

    // Relasi ke User (opsional karena bisa null)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Outlet
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Relasi ke Top-up Saldo
    public function topups()
    {
        return $this->hasMany(Topup::class);
    }
    // Relasi ke Penggunaan Saldo
    public function penggunaanSaldo()
    {
        return $this->hasMany(PenggunaanSaldo::class);
    }
    public function promoMember()
    {
        return $this->hasMany(PromoMember::class);
    }

    // Relasi ke Promo Member
    public function promo()
    {
        return $this->hasMany(PromoMember::class);
    }
}