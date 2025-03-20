@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">User</h3>

                    <div class="card-tools d-flex align-items-center ml-auto">

                         <form method="GET" action="{{ url('master/level/list') }}" class="d-flex align-items-center">

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

                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUser">Add User</button>
                    </div>
                </div>


                <div class="card-body table-responsive" style="border-top: 1px solid #dee2e6;">
                    <table class="table  table-bordered table-hover mt-2" style="width: 100%; table-layout: fixed;border-top: 1px solid #d3d3d3;"">
                        <thead>
                            <tr>
                                <th style="width: 50px">No</th>
                                <th style="width: 300px">Name</th>
                                <th style="width: 250px">email</th>
                                <th style="width: 120px">role</th>
                                <th style="width: 200px">No Hp</th>
                                <th style="width: 200px">Tanggal lahir</th>
                                <th style="width: 200px">Tanggal masuk</th>
                                <th style="width: 400px">Alamt</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($user) == 0)
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endif
                            @foreach ($user as $i => $u)
                                <tr>
                                    <td style="max-width: 50px">  {{ $i + 1 }} </td>
                                    <td style="max-width: 300px"> {{ $u->name }} </td>
                                    <td style="max-width: 250px"> {{ $u->email }} </td>
                                    <td style="max-width: 100px"> {{ $u->role }} </td>
                                    <td style="max-width: 200px"> {{ $u->no_hp }} </td>
                                    <td style="max-width: 200px"> {{ $u->tanggal_lahir }} </td>
                                    <td style="max-width: 200px"> {{ $u->tanggal_masuk }} </td>
                                    <td style="max-width: 400px"> {{ $u->alamat }} </td>
                                    <td >
                                        <form id="delete-form-{{ $u->id }}" action="{{ url('/master/user/delete/'.$u->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $u->id }}" ><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        <a href="{{ url('/master/user/suting', $u->id) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto m-2">
                        <p>Showing {{ $user->firstItem() }} to {{ $user->lastItem() }} of {{ $user->total() }} entries</p>
                    </div>
                    <div class="col-auto m-2">
                        {{$user->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>


    
  @include('admin_page.user.addUserModal')

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
