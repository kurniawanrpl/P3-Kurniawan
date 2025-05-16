@extends('admin/index')
@section('content')
<div class="container">
    <h4 class="mb-4">Manajemen Paket Laundry</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah/Edit --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($paket) ? 'Edit Paket' : 'Tambah Paket' }}</div>
        <div class="card-body">
            <form method="POST" action="{{ isset($paket) ? route('paket_laundry.update', $paket->id) : route('paket_laundry.store') }}">
                @csrf
                @if(isset($paket))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <label for="outlet_id" class="col-sm-2 col-form-label">Outlet</label>
                    <div class="col-sm-10">
                        <select name="outlet_id" class="form-control" required>
                            
                            @foreach($outlets as $outlet)
                                <option value="{{ $outlet->id }}" {{ (old('outlet_id', $paket->outlet_id ?? '') == $outlet->id) ? 'selected' : '' }}>
                                    {{ $outlet->nama_outlet }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama Paket</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_paket" class="form-control" value="{{ old('nama_paket', $paket->nama_paket ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jenis</label>
                    <div class="col-sm-10">
                        <select name="jenis" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach(['kiloan', 'selimut', 'bed_cover', 'kaos', 'lain'] as $jenis)
                                <option value="{{ $jenis }}" {{ (old('jenis', $paket->jenis ?? '') == $jenis) ? 'selected' : '' }}>{{ ucfirst($jenis) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="number" name="harga" class="form-control" step="0.01" value="{{ old('harga', $paket->harga ?? '') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($paket) ? 'Update' : 'Tambah ke Daftar Sementara' }}</button>

                @if(isset($paket))
                    <a href="{{ route('paket_laundry.index') }}" class="btn btn-secondary">Batal</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Tombol Simpan dan Reset Sementara --}}
    @if(count($temp_pakets))
        <div class="mb-3">
            <form action="{{ route('paket_laundry.simpan') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-success">Simpan ke Database</button>
            </form>

            <form action="{{ route('paket_laundry.temp.reset') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-danger">Reset Daftar Sementara</button>
            </form>
        </div>
    @endif

    {{-- Tabel Data Sementara --}}
    @if(count($temp_pakets))
        <h5>Daftar Sementara</h5>
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>Outlet</th>
                    <th>Nama Paket</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($temp_pakets as $index => $item)
                    <tr>
                        <td>{{ $outlets->where('id', $item['outlet_id'])->first()->nama_outlet ?? '-' }}</td>
                        <td>{{ $item['nama_paket'] }}</td>
                        <td>{{ ucfirst($item['jenis']) }}</td>
                        <td>Rp{{ number_format($item['harga'], 2, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('paket_laundry.temp.delete', $index) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data sementara ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Tabel Data dari Database --}}
    <h5>Data Paket Laundry</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Outlet</th>
                <th>Nama Paket</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pakets as $data)
                <tr>
                    <td>{{ $data->outlet->nama_outlet ?? '-' }}</td>
                    <td>{{ $data->nama_paket }}</td>
                    <td>{{ ucfirst($data->jenis) }}</td>
                    <td>Rp{{ number_format($data->harga, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('paket_laundry.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('paket_laundry.destroy', $data->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection