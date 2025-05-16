@extends('admin.index')
@section('content')

<div class="container mt-4">
    <h2>Manajemen Pengguna</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            @if(Route::currentRouteName() == 'user.pengguna.confirmDelete')
                Hapus Pengguna
            @elseif(isset($user))
                Edit Pengguna
            @else
                Tambah Pengguna ke Daftar Sementara
            @endif
        </div>
        <div class="card-body">
            <form action="{{ 
                Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 
                    route('user.pengguna.destroy', $user->id) : 
                    (isset($user) ? route('user.pengguna.update', $user->id) : route('user.pengguna.store')) 
            }}" method="POST">
                @csrf
                @if(isset($user))
                    @if(Route::currentRouteName() == 'user.pengguna.confirmDelete')
                        @method('DELETE')
                    @else
                        @method('PUT')
                    @endif
                @endif

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name ?? '') }}"
                           {{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'readonly' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email ?? '') }}"
                           {{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'readonly' : 'required' }}>
                </div>

                <div class="mb-3 d-none">
                    <label>Outlet</label>
                    <select name="outlet_id" class="form-control"
                            {{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'disabled' : 'required' }}>
                        
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ (old('outlet_id', $user->outlet_id ?? '') == $outlet->id) ? 'selected' : '' }}>
                                {{ $outlet->nama_outlet }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
    <div class="mb-3">
        <label>Telepon</label>
        <input type="number" name="telepon" class="form-control"
               value="{{ old('telepon', $user->telepon ?? '') }}"{{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'readonly' : 'required' }}>
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"{{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'readonly' : 'required' }}>{{ old('alamat', $user->alamat ?? '') }}</textarea>
    </div>

                @if(Route::currentRouteName() != 'user.pengguna.confirmDelete')
                    <div class="mb-3">
                        <label>Password {{ isset($user) ? '(Isi jika ingin mengganti)' : '' }}</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                @endif
               
                <button type="submit" class="btn {{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'btn-danger' : 'btn-primary' }}">
                    {{ Route::currentRouteName() == 'user.pengguna.confirmDelete' ? 'Konfirmasi Hapus' : (isset($user) ? 'Update' : 'Tambah ke List') }}
                </button>
            </form>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('user.pengguna.simpan') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">Simpan ke Database</button>
        </form>
    </div>

    <div class="card mb-4">
        <div class="card-header">Data Sementara</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                <tr><th>Nama</th><th>Email</th><th>alamat</th><th>telepon</th><th>Outlet</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($temp_users as $index => $temp)
                        <tr>
                            <td>{{ $temp['name'] }}</td>
                            <td>{{ $temp['email'] }}</td>
                            <td>{{ $temp['alamat'] }}</td>
                            <td>{{ $temp['telepon'] }}</td>
                            <td>{{ \App\Models\Outlet::find($temp['outlet_id'])->nama_outlet ?? '-' }}</td>
                            <td>
                                <form action="{{ route('user.pengguna.temp-delete', $index) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
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
    <h2> <a href='{{ route('user.penggunalaporan') }}' class="btn btn-primary">laporan</a></h2>
    <div class="card">
        <div class="card-header">Data dari Database</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                <tr><th>Nama</th><th>Email</th><th>alamat</th><th>telepon</th><th>Outlet</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->alamat }}</td>
                            <td>{{ $u->telepon }}</td>
                            <td>{{ $u->outlet->nama_outlet ?? '-' }}</td>
                            <td>
                                <a href="{{ route('user.pengguna.edit', $u->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('user.pengguna.confirmDelete', $u->id) }}" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
