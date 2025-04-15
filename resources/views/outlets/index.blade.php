@extends('admin/index')

@section('content')
<div class="container">
    <h2 class="mb-4">Manajemen Outlet</h2>

    {{-- Form Tambah / Edit --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($editData) ? 'Edit Outlet' : 'Tambah Outlet' }}</div>
        <div class="card-body">
            <form action="{{ isset($editData) ? route('outlets.update', $editData->id) : route('outlets.storeTemp') }}" method="POST">
                @csrf
                @if(isset($editData))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="nama_outlet" class="form-label">Nama Outlet</label>
                    <input type="text" name="nama_outlet" class="form-control" required value="{{ old('nama_outlet', $editData->nama_outlet ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" required>{{ old('alamat', $editData->alamat ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" required value="{{ old('telepon', $editData->telepon ?? '') }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($editData) ? 'Update' : 'Tambah ke Daftar Sementara' }}</button>
                @if(!isset($editData))
                    <button type="submit" formaction="{{ route('outlets.saveTemp') }}" class="btn btn-success">Simpan Semua ke Database</button>
                    <button type="submit" formaction="{{ route('outlets.resetTemp') }}" class="btn btn-danger">Reset Daftar Sementara</button>
                @endif
            </form>
        </div>
    </div>

    {{-- Data Sementara --}}
    @if(session('outlets') && count(session('outlets')) > 0)
    <div class="card mb-4">
        <div class="card-header">Data Sementara</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Outlet</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('outlets') as $outlet)
                    <tr>
                        <td>{{ $outlet['nama_outlet'] }}</td>
                        <td>{{ $outlet['alamat'] }}</td>
                        <td>{{ $outlet['telepon'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Data Tersimpan --}}
    <div class="card">
        <div class="card-header">Data Outlet Tersimpan</div>
        <div class="card-body">
            @if($data->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Outlet</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->nama_outlet }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>
                            <a href="{{
::contentReference[oaicite:0]{index=0}
@endsection
