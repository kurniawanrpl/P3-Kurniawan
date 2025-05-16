@extends('admin/index')
@section('content')
<div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                 
                  <h4>Laporan pengguna</h4>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                   
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            
                           
<!-- page content -->
        
                      <!-- info row -->
                      
                      <!-- Table row -->

                      <div class="row">
                        <div class="  table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                               
                                <th>nama</th>
                                <th>email</th>
                                <th>telepon</th>
                                <th>alamat</th>
                                <th>outlet</th>
                               
                              </tr>
                            </thead>
                            <tbody>
                            @php
        $counter = 1; // Inisialisasi penghitung
    @endphp
           
    @forelse($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->alamat }}</td>
                            <td>{{ $u->telepon }}</td>
                            <td>{{ $u->outlet->nama_outlet ?? '-' }}</td>
                              </tr>
                            </tbody>
                            @php
            $counter++; // Increment penghitung
        @endphp
            @endforeach
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <div class="row">
                        <!-- accepted payments column -->
                        
                        <!-- /.col -->
                        <div class="col-md-6">
                         
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                
                                
                                
                                
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                        <div class=" ">
                          <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                          <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
                          <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

@endsection