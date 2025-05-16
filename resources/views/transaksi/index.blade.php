@extends('admin.index')
@section('content')
<div class="container">
    <h2>Transaksi Laundry</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Form Tambah Item -->
    <form method="POST" action="{{ route('transaksi.tambahItem') }}">
        @csrf
        @if (in_array($user->role, ['admin','supervisor', 'petugas']))
    <div class="form-group">
        <label for="pengguna_id">Pilih Pengguna</label>
        <select name="pengguna_id" id="pengguna_id" class="form-control" required>
            <option value="">-- Pilih Pengguna --</option>
            @foreach ($penggunas as $p)
                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
            @endforeach
        </select>
    </div>
@endif
        <div class="row mb-3">
            <div class="col-md-5">
                <select name="paket_id" class="form-control" required>
                    <option value="">Pilih Paket</option>
                    @foreach($paket as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_paket }} - {{ $p->jenis }} - Rp{{ number_format($p->harga) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="qty" class="form-control" placeholder="Qty" min="1" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success">Tambah</button>
            </div>
        </div>
    </form>

    <!-- Daftar Item -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Paket</th>
                
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($todo as $key => $item)
                <tr>
                    <td>{{ $item['nama_paket'] }}</td>
                 
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp{{ number_format($item['subtotal']) }}</td>
                    <td>
                    <form action="{{ route('transaksi.hapusItem', $key) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        @if(count($todo) > 0)
        <tfoot>
            <tr>
                <th colspan="2" class="text-end">Total</th>
                <th colspan="2">Rp{{ number_format($total) }}</th>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Form Simpan Transaksi -->
    @if(count($todo) > 0)
    <form method="POST" action="{{ route('transaksi.simpan') }}">
        @csrf
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                <option value="">Pilih Metode</option>
                <option value="cash">Cash</option>
                @if($user->member && $user->member->midtrans_payment_status === 'paid')
    <option value="saldo">Saldo (Sisa: Rp{{ number_format($user->member->saldo) }})</option>
@endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
    </form>
    @endif
</div>
<h4 class="mt-4">Riwayat Transaksi Anda</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Metode</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
    @forelse($transaksis as $trx)
        <tr>
            <td>{{ $trx->kode_transaksi }}</td>
            <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
            <td>Rp{{ number_format($trx->total) }}</td>
            <td>{{ ucfirst($trx->status) }}</td>
            <td>{{ ucfirst($trx->metode_pembayaran) }}</td>
            <td>
                <ul class="mb-0">
                    @foreach($trx->details as $detail)
                        <li>{{ $detail->paket->nama_paket }} (x{{ $detail->qty }}) - Rp{{ number_format($detail->subtotal) }}</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ $trx->user->name ?? '-' }}</td>
            <td>
                @if(in_array($user->role, ['admin', 'supervisor', 'petugas']))
                    <form method="POST" action="{{ route('transaksi.ubahStatus', $trx->id) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                            <option value="proses" {{ $trx->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $trx->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $trx->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </form>
                @elseif($trx->user_id === $user->id && $trx->status === 'proses')
                    <form method="POST" action="{{ route('transaksi.ubahStatus', $trx->id) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="dibatalkan">
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">Batalkan</button>
                    </form>
    @else
        {{ ucfirst($trx->status) }}
    @endif
</td>
                
                
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada transaksi.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection