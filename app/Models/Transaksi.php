<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi', 'outlet_id', 'member_id', 'user_id',
        'total', 'metode_pembayaran', 'status'
    ];

    public function paket()
    {
        return $this->belongsTo(PaketLaundry::class, 'paket_id');
    }

    public function details()
{
    return $this->hasMany(TransaksiDetail::class);
}

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
