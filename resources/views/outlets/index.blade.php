@extends('admin/index')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Manajemen Outlet</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah/Edit --}}
    <div class="card mb-4">
        <div class="card-header">
            {{ isset($outlet) ? 'Edit Outlet' : 'Tambah ke Daftar Sementara' }}
        </div>
        <div class="card-body">
        <form action="{{ isset($outlet) ? (request()->is('*/hapus') ? route('outlets.destroy', $outlet->id) : route('outlets.update', $outlet->id)) : route('outlets.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($outlet))
        @if(request()->is('*/hapus'))
            @method('DELETE')
        @else
            @method('PUT')
        @endif
    @endif

    <div class="mb-3">
        <label for="nama_outlet" class="form-label">Nama Outlet</label>
        <input type="text" name="nama_outlet" id="nama_outlet" class="form-control" 
               value="{{ old('nama_outlet', $outlet->nama_outlet ?? '') }}" 
               {{ request()->is('*/hapus') ? 'readonly' : 'required' }}>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" name="alamat" id="alamat" class="form-control" 
               value="{{ old('alamat', $outlet->alamat ?? '') }}" 
               {{ request()->is('*/hapus') ? 'readonly' : 'required' }}>
    </div>

    <div class="mb-3">
        <label for="telepon" class="form-label">Telepon</label>
        <input type="text" name="telepon" id="telepon" class="form-control" 
               value="{{ old('telepon', $outlet->telepon ?? '') }}" 
               {{ request()->is('*/hapus') ? 'readonly' : 'required' }}>
    </div>
    <div class="mb-3">
    <label for="foto" class="form-label">Foto Outlet (Opsional)</label>
    <input type="file" name="foto" id="foto" class="form-control"
        {{ request()->is('*/hapus') ? 'disabled' : '' }}>

    @if (!request()->is('*/create') && isset($outlet) && $outlet->foto)
        <div class="mt-2">
            <img src="{{ asset('uploads/outlet/' . $outlet->foto) }}" alt="Foto Outlet" style="max-height: 150px;">
        </div>
    @endif
</div>

    <button type="submit" class="btn {{ request()->is('*/hapus') ? 'btn-danger' : 'btn-primary' }}">
        {{ request()->is('*/hapus') ? 'Konfirmasi Hapus' : (isset($outlet) ? 'Update' : 'Tambah ke List') }}
    </button>
</form>
        </div>
    </div>
    

    {{-- Tombol Simpan ke DB dan Reset --}}
    <div class="mb-4">
        <form action="{{ route('outlets.simpan') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">Simpan Semua ke Database</button>
        </form>

        <form action="{{ route('outlets.temp.reset') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Reset Daftar Sementara</button>
        </form>
    </div>

    {{-- Tabel Sementara --}}
    <div class="card mb-4">
        <div class="card-header">Daftar Sementara</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama</th><th>Alamat</th><th>Telepon</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($temp_outlets as $index => $temp)
                        <tr>
                            <td>{{ $temp['nama_outlet'] }}</td>
                            <td>{{ $temp['alamat'] }}</td>
                            <td>{{ $temp['telepon'] }}</td>
                            
                            <td>
                                <form action="{{ route('outlets.temp.delete', $index) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Tidak ada data sementara.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel dari Database --}}
    <div class="card">
        <div class="card-header">Data dari Database</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama</th><th>Alamat</th><th>Telepon</th><th>Foto</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($outlets as $data)
                        <tr>
                            <td>{{ $data->nama_outlet }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->telepon }}</td>
                            <td>
    @if($data->foto)
        <img src="{{ asset('uploads/outlet/' . $data->foto) }}" width="60">
    @else
        <em>Tidak ada foto</em>
    @endif
</td>
                            <td>
                                <a href="{{ route('outlets.edit', $data->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="{{ route('outlets.confirmDelete', $data->id) }}" class="btn btn-sm btn-outline-danger">Hapus</a>

                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada data outlet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection