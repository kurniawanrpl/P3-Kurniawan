@extends('admin/index')
@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Profil Pengguna</h4>
        </div>
        <div class="card-body">
          <div class="text-center mb-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="rounded-circle" width="100" height="100" alt="Avatar">
          </div>
          <table class="table table-borderless">
            <tr>
              <th>Nama</th>
              <td>{{ Auth::user()->name }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
              <th>alamat</th>
              <td>{{ Auth::user()->alamat }}</td>
            </tr>
            <tr>
              <th>telepon</th>
              <td>{{ Auth::user()->telepon }}</td>
            </tr>
            <tr>
              <th>Outlet</th>
              <td>{{ Auth::user()->outlet->nama_outlet ?? '-' }}</td>
            </tr>
          </table>
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

          <div class="text-right">
            <a href="{{ route('profile.edit') }}" class="btn btn-warning">
              <i class="fa fa-edit"></i> Edit Profil
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
