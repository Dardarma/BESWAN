@extends('admin_page.layout')
@section('style')

@endsection
@section('content')

<div class="container-fluid mt-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
           
            <h3 class="card-title">User Activity</h3>
            <div class="card-tools d-flex align-items-center ml-auto">
                <form method="GET" action="{{ url('/master/daily_activity') }}" class="d-flex align-items-center">
                    <div class="input-group input-group-sm" style="width: 80px; margin-right: 10px;">
                        <select class="custom-select" name="paginate" onchange="this.form.submit()">
                            <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                
                    <div class="input-group input-group-sm" style="width: 150px; margin-right: 10px;">
                        <input type="text" name="table_search" class="form-control" placeholder="Search" value="{{ request('table_search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>                        
        
                <!-- Add Level Button -->
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add" >Add Feed</button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @php
              $chunks = $user->chunk(ceil($user->count() / 2));   
            @endphp
            
            <!-- TABEL MOBILE (1 TABLE) -->
            <div class="d-block d-md-none">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="width:5vw;">No</th>
                    <th>User</th>
                    <th style="width:10vw;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user as $key => $item)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                      <a href="{{ url('/user_activity/activity/'. $item->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Aksi</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          
            <!-- TABEL DESKTOP (2 TABLE) -->
            <div class="row d-none d-md-flex">
              <div class="col-md-6">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width:5vw;">No</th>
                      <th>User</th>
                      <th style="width:10vw;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($chunks[0] as $key => $item)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $item->name }}</td>
                      <td>
                        <a href="{{ url('/user_activity/activity/'. $item->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>User</th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
          
              @if(isset($chunks[1]))
              <div class="col-md-6">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width:5vw;">No</th>
                      <th>User</th>
                      <th style="width:10vw;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($chunks[1] as $key => $item)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $item->name }}</td>
                      <td>
                        <a href="{{ url('/user_activity/activity/'. $item->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>User</th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              @endif
            </div>
          </div>
          
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </div>
  @endsection
