<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoMember extends Model
{
    use HasFactory;

    protected $table = 'promo_member';

    protected $fillable = [
        'nama_promo',
        'diskon_persen',
        'member_id',
        'mulai',
        'selesai',
    ];

    protected $dates = [
        'mulai',
        'selesai',
    ];

    // Relasi ke Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
