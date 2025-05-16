@extends('admin/index')
@section('content')
<div class="container">
    <h1>Daftar Member</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Email</th>
                <th>Saldo</th>
                <th>Status Pembayaran</th>
                @if(in_array(Auth::user()->role, ['owner','admin','supervisor']))
                <th>hapus dari member</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr>
                    <td>{{ $member->user->name ?? '-' }}</td>
                    <td>{{ $member->user->email ?? '-' }}</td>
                    <td>Rp {{ number_format($member->saldo, 2, ',',) }}</td>
                    <td>{{ $member->midtrans_payment_status ?? 'Belum bayar' }}</td>
                    @if(in_array(Auth::user()->role, ['owner','admin','supervisor']))
                    <td>  <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus member ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>
@endif
</td>
                </tr>
                
            @empty
                <tr>
                    <td colspan="4">Tidak ada member yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
