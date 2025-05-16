@extends('admin.index')
@section('content')
<div class="container">
    <h4 class="mb-4">Promo Diskon Member</h4>

    {{-- Form Tambah / Edit --}}
    <form action="{{ isset($edit) ? route('promo.member.update', $edit->id) : route('promo.member.store') }}" method="POST">
        @csrf
        @if(isset($edit))
            @method('PUT')
        @endif
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nama_promo" class="form-label">Nama Promo</label>
                <input type="text" class="form-control" name="nama_promo" value="{{ old('nama_promo', $edit->nama_promo ?? '') }}" required>
            </div>
            <div class="col-md-2">
                <label for="diskon_persen" class="form-label">Diskon (%)</label>
                <input type="number" class="form-control" name="diskon_persen" value="{{ old('diskon_persen', $edit->diskon_persen ?? '') }}" required>
            </div>
            <div class="col-md-3">
                <label for="mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="mulai" value="{{ old('mulai', $edit->mulai ?? '') }}" required>
            </div>
            <div class="col-md-3">
                <label for="selesai" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" name="selesai" value="{{ old('selesai', $edit->selesai ?? '') }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="member_id" class="form-label">Pilih Member</label>
                <select class="form-control" name="member_id" required>
                    <option value="">-- Pilih Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id', $edit->member_id ?? '') == $member->id ? 'selected' : '' }}>
                            {{ $member->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            {{ isset($edit) ? 'Update Promo' : 'Tambah ke Daftar' }}
        </button>
        @if(isset($edit))
            <a href="{{ route('promo.member') }}" class="btn btn-secondary">Batal</a>
        @endif
    </form>

    {{-- Tombol Simpan Semua --}}
    @if(session('temp_promos') && count(session('temp_promos')) > 0)
    <form action="{{ route('promo.member.simpan') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-success">Simpan Semua ke Database</button>
    </form>
    @endif

    {{-- Tabel Data Sementara --}}
    @if(session('temp_promos'))
    <h5 class="mt-4">Daftar Sementara</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>Nama Promo</th>
                    <th>Diskon (%)</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Member</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('temp_promos') as $index => $item)
                <tr>
                    <td>{{ $item['nama_promo'] }}</td>
                    <td>{{ $item['diskon_persen'] }}</td>
                    <td>{{ $item['mulai'] }}</td>
                    <td>{{ $item['selesai'] }}</td>
                    <td>{{ \App\Models\Member::find($item['member_id'])->nama ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('promo.member.deleteTemp', $index) }}" method="POST" onsubmit="return confirm('Hapus data ini dari daftar sementara?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Tabel Data dari Database --}}
    <h5 class="mt-4">Data Promo Member</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>Nama Promo</th>
                    <th>Diskon (%)</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Member</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $item)
                <tr>
                    <td>{{ $item->nama_promo }}</td>
                    <td>{{ $item->diskon_persen }}</td>
                    <td>{{ $item->mulai }}</td>
                    <td>{{ $item->selesai }}</td>
                    <td>{{ $item->member->nama }}</td>
                    <td>
                        <a href="{{ route('promo.member.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('promo.member.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Belum ada data promo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection