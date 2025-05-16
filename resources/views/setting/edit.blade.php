@extends('admin.index')
@section('content')

<div class="container mt-4">
    <h3>Pengaturan Outlet Anda</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama Outlet</label>
            <input type="text" name="nama_outlet" class="form-control" value="{{ old('nama_outlet', $outlet->nama_outlet) }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $outlet->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $outlet->telepon) }}" required>
        </div>

        <div class="mb-3">
            <label>Foto Outlet</label><br>
            @if($outlet->foto)
                <img src="{{ asset('uploads/outlet/'.$outlet->foto) }}" width="120" class="mb-2"><br>
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

@endsection
