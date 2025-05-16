@extends('admin.index')
@section('content')

<div class="container mt-4">
    <h2>Manajemen Supervisor</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            @if(Route::currentRouteName() == 'user.supervisor.confirmDelete')
                Hapus Supervisor
            @elseif(isset($user))
                Edit Supervisor
            @else
                Tambah Supervisor ke Daftar Sementara
            @endif
        </div>
        <div class="card-body">
            <form action="{{ 
                Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 
                    route('user.supervisor.destroy', $user->id) : 
                    (isset($user) ? route('user.supervisor.update', $user->id) : route('user.supervisor.store')) 
            }}" method="POST">
                @csrf
                @if(isset($user))
                    @if(Route::currentRouteName() == 'user.supervisor.confirmDelete')
                        @method('DELETE')
                    @else
                        @method('PUT')
                    @endif
                @endif

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name ?? '') }}"
                           {{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'readonly' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email ?? '') }}"
                           {{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'readonly' : 'required' }}>
                </div>

                <div class="mb-3 d-none">
                    <label>Outlet</label>
                    <select name="outlet_id" class="form-control"
                            {{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'disabled' : 'required' }}>
                        
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ (old('outlet_id', $user->outlet_id ?? '') == $outlet->id) ? 'selected' : '' }}>
                                {{ $outlet->nama_outlet }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(Route::currentRouteName() != 'user.supervisor.confirmDelete')
                    <div class="mb-3">
                        <label>Password {{ isset($user) ? '(Isi jika ingin mengganti)' : '' }}</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                @endif
                @if(Route::currentRouteName() != 'user.pengguna.confirmDelete')
    <div class="mb-3">
        <label>Telepon</label>
        <input type="text" name="telepon" class="form-control"
               value="{{ old('telepon', $user->telepon ?? '') }}"
               {{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'readonly' : 'required' }}>
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"{{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'readonly' : 'required' }}>{{ old('alamat', $user->alamat ?? '') }}</textarea>
    </div>
@endif

                <button type="submit" class="btn {{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'btn-danger' : 'btn-primary' }}">
                    {{ Route::currentRouteName() == 'user.supervisor.confirmDelete' ? 'Konfirmasi Hapus' : (isset($user) ? 'Update' : 'Tambah ke List') }}
                </button>
            </form>
        </div>
    </div>

    <div class="mb-3">
        <form action="{{ route('user.supervisor.simpan') }}" method="POST" class="d-inline">
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
                                <form action="{{ route('user.supervisor.temp-delete', $index) }}" method="POST">
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
    <h2> <a href='{{ route('user.supervisorlaporan') }}' class="btn btn-primary">laporan</a></h2>
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
                                <a href="{{ route('user.supervisor.edit', $u->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('user.supervisor.confirmDelete', $u->id) }}" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada data supervisor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
