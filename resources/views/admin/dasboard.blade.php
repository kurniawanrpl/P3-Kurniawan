@extends('admin/index')
@section('content')
    


<div class="row" style="display: inline-block;">
  <div class="tile_count">
    <div class="col-md-4 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Pengguna</span>
      <div class="count">{{ $totalPengguna }}</div>
      <span class="count_bottom"><i class="green">4% </i> From last Week</span>
    </div>
    <div class="col-md-4 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-clock-o"></i> Total Member</span>
      <div class="count">{{ $totalmember }}</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
    </div>
    <div class="col-md-4 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Petugas</span>
      <div class="count green">{{ $totalpetugas }}</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
  </div>
</div>

@endsection