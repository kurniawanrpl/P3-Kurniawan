<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'alamat',
        'telepon',
        'password',
        'role',
        'outlet_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function member()
{
    return $this->hasOne(Member::class);
}
}
