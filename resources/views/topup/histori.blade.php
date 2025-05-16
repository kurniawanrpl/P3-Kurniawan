@extends('admin/index')
@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Riwayat Top Up</h3>

    @if($topups->isEmpty())
        <div class="alert alert-info">Belum ada riwayat topup.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topups as $topup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $topup->order_id }}</td>
                            <td>Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $topup->status === 'settlement' ? 'success' : 'warning' }}">
                                    {{ ucfirst($topup->status) }}
                                </span>
                            </td>
                            <td>{{ $topup->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
