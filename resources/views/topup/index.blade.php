@extends('admin/index')
@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Top Up Saldo</h3>

    

    <form action="{{ route('topup.proses') }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah Topup</label>
            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Minimal 10.000" required>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Topup Sekarang</button>
    </form>
</div>
@endsection
