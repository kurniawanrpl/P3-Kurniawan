@extends('admin/index')
@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card shadow-lg rounded">
        <div class="card-header bg-warning text-white">
          <h4 class="mb-0">Edit Profil</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="form-group">
              <label for="name">Nama Lengkap</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
              @error('name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
  <label for="telepon">Telepon</label>
  <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}">
  @error('telepon')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>

<div class="form-group">
  <label for="alamat">Alamat</label>
  <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
  @error('alamat')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>


@if(in_array(Auth::user()->role, ['pengguna']))
<div class="form-group">
  <label for="outlet_id">ganti cabang</label>
  <select name="outlet_id" class="form-control">
    <option value="">-- Pilih Outlet --</option>
    @foreach ($outlets as $outlet)
      <option value="{{ $outlet->id }}" {{ $user->outlet_id == $outlet->id ? 'selected' : '' }}>
        {{ $outlet->nama_outlet }}
      </option>
    @endforeach
  </select>
  @error('outlet_id')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>
@endif
@php
    $role = auth()->user()->role ?? null;
@endphp

@if(in_array($role, ['admin', 'supervisor', 'petugas']))
    <div class="alert alert-info text-end">
        Anda adalah <strong>{{ ucfirst($role) }}</strong>
    </div>
@elseif($global_member)
    <div class="alert alert-success text-end">
        <strong>Saldo Anda:</strong> Rp{{ number_format($global_member->saldo, 0, ',', '.') }}
    </div>
@else
    <div class="alert alert-warning text-end">
        Anda belum memiliki akun member.
    </div>
@endif


            <div class="form-group">
              <label for="password">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin ubah)</small></label>
              <input type="password" name="password" class="form-control">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control">
            </div>
            

            <div class="text-right">
              <a href="{{ route('profile.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
          
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
