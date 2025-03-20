@extends('admin_page.layout')
@section('style')

@endsection
@section('content')

<div class="container-fluid mt-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
           
            <h3 class="card-title">Article Materi</h3>
            <div class="card-tools d-flex align-items-center ml-auto">
                <form method="GET" action="{{ url('/article') }}" class="d-flex align-items-center">
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
                <a href="{{url('/article/create')}}" type="button" class="btn btn-info btn-sm">Add Article</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="data" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th style="width:5vw">No</th>
                <th style="width: 20vw;">Judul</th>
                <th style="width: 35vw;">Deskripsi</th>
                <th style="width:5vw">Level</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>
                @foreach($article as $key => $item)
                <tr>
                  <td> {{ $key +1 }} </td>
                  <td> {{ $item->judul}} </td>
                  <td> {{ $item->deskripsi}} </td>
                  <td> {{ $item->level->urutan_level}} </td>
                  <td>
                      <a  class="btn btn-primary btn-edit btn-sm" href="{{url('/article/edit/'.$item->id)}}">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <form id="delete-form-{{ $item->id }}" method="POST" style="display:inline;" action="{{url('/article/delete/'.$item->id)}}">
                        @csrf
                        @method('DELETE') 
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" ><i class="fa-solid fa-trash"></i></button>
                      </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Level</th>
                <th>Aksi</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>

  </div>
  @endsection
  @section('script')


  <script>

  document.addEventListener('DOMContentLoaded',function(){
    document.querySelectorAll('.btn-delete').forEach(function(button){
        button.addEventListener('click',function(){
            let formId = button.getAttribute('data-id');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-'+ formId).submit();
                }
        })
    })
    })
  })

  </script>
  @endsection