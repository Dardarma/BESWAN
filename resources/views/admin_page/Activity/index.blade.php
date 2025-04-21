@extends('admin_page.layout')
@section('style')

@endsection
@section('content')

<div class="container-fluid mt-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
           
            <h3 class="card-title">Aktivitas Harian</h3>
            <div class="card-tools d-flex align-items-center ml-auto">
                <form method="GET" action="{{ url('/admin/master/daily_activity') }}" class="d-flex align-items-center">
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
            <table id="data" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th style="width:5vw;">No</th>
                <th>Nama</th>
                <th style="width:10vw;">Aksi</th>
              </tr>
              </thead>
              <tbody>
                @foreach($daily_activity as $key => $item)
                <tr>
                  <td> {{ $key +1 }} </td>
                  <td> 
                    {{ $item->activity }}
                  </td>
                  <td>
                      <a  
                        class="btn btn-warning btn-edit btn-sm"
                        data-toggle="modal"
                        data-target="#edit"
                        data-id="{{ $item->id }}"
                        data-activity="{{ $item->activity }}"
                      >
                      <i class="fa-solid fa-pencil"></i></a>
                      <form id="delete-form-{{ $item->id }}" method="POST" style="display:inline;" action="{{url('/admin/master/daily_activity/delete/'.$item->id)}}">
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
                <th>Aktivitas</th>
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
    <!-- /.row -->
    @include('admin_page.Activity.add')
    @include('admin_page.Activity.edit')
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

  $('.btn-edit').on('click', function () {
    let id = $(this).data('id');
    let activity = $(this).data('activity');
 
    $('#edit').find('form').attr('action', '/admin/master/daily_activity/update/' + id);

    $('#edit').find('input[name="id"]').val(id);
    $('#edit').find('input[name="activity"]').val(activity);
    
  
    $('#edit').modal('show');
});

</script>
  @endsection