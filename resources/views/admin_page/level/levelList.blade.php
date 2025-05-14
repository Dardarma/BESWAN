@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ url('/admin/master/level/user')}}" type="button" class="btn btn-secondary mx-2">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3 class="card-title">Level</h3>
                    <div class="card-tools d-flex align-items-center ml-auto">
                        <button type="button" class="btn btn-info btn-sm mx-1" data-toggle="modal" data-target="#orderLevel" >Ordering Level</button>
                        <form method="GET" action="{{ url('/admin/master/level/list') }}" class="d-flex align-items-center">
                            <!-- Pagination Dropdown -->
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
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addLevel" >+ Level</button>
                    </div>
                </div>
                
                

                <div class="card-body">  
                    <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                        <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                          <thead style="background-color: #578FCA; color: white;">
                            <tr>
                                <th style="width: 5vw">No</th>
                                <th style="width: 10vw">Nama Level</th>
                                <th style="width: 40vw">Deskripsi Level</th>
                                <th style="width: 7vw">Warna</th>
                                <th style="width: 6vw">Urutan</th>
                                <th style="width: 8vw">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($level) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endif
                            @foreach ($level as $key => $item)
                                <tr>
                                    <td>{{ $level->firstItem() + $key }}</td>
                                    <td>{{ $item->nama_level }}</td>
                                    <td>{{ $item->deskripsi_level }}</td>
                                    <td> <span class="badge" style="background-color: {{ $item->warna }}; width: 3vw; height: 3vw; display: inline-block;"></span> </td>
                                    <td>{{ $item->urutan_level}}</td>
                                    <td>
                                        <a 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit" 
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama_level }}"
                                            data-deskripsi="{{ $item->deskripsi_level }}"
                                            data-urutan="{{ $item->urutan_level }}"
                                            data-warna="{{ $item->warna }}"
                                            class="btn btn-warning btn-sm btn-edit"
                                        ><i class="fa-solid fa-pencil"></i></a>
                                        <form  method="POST" id="delete-form-{{ $item->id }}" action="{{url('/admin/master/level/delete/'.$item->id)}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" ><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto m-2">
                        <p>Showing {{ $level->firstItem() }} to {{ $level->lastItem() }} of {{ $level->total() }} entries</p>
                    </div>
                    <div class="col-auto m-2">
                        {{$level->links()}}
                    </div>
                </div>
                </div>
            </div>



    </div>
@include('admin_page.level.addLevelModal')
@include('admin_page.level.editLevelModal')
@include('admin_page.level.orderLevel')
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let deskripsi = $(this).data('deskripsi');
        let urutan = $(this).data('urutan');
        let warna = $(this).data('warna');

        $('#editLevel').find('form').attr('action', '/admin/master/level/edit/' + id);

        // Populate modal inputs
        $('#editLevel').find('input[name="id"]').val(id);
        $('#editLevel').find('input[name="nama_level"]').val(nama);
        $('#editLevel').find('input[name="deskripsi_level"]').val(deskripsi);
        $('#editLevel').find('input[name="urutan_level"]').val(urutan);
        $('#editLevel').find('input[name="warna"]').val(warna);

        // Open modal (if needed)
        $('#editLevel').modal('show');
    });
});

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
