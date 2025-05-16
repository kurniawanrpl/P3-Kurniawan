@extends('admin/index')
@section('content')
<div class="container mt-5">
    <div class="alert alert-success text-center shadow-sm rounded">
        <h3 class="mb-3"><i class="bi bi-check-circle-fill me-2"></i> Pembayaran Berhasil!</h3>
        <p>Selamat! Anda telah resmi menjadi member.</p>
        <p>Akun Anda kini bisa digunakan untuk transaksi laundry.</p>

        <a href="{{ route('dasboard') }}" class="btn btn-success mt-4">
            <i class="bi bi-house-door-fill me-1"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
