<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paketlaundry extends Model
{
    use HasFactory;

    protected $table = 'paket_laundry';

    protected $fillable = [
        'outlet_id',
        'nama_paket',
        'jenis',
        'harga',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'paket_id');
    }
}
