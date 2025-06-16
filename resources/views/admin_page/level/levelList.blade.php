@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <div class="d-flex align-items-center">
                                <a href="{{ url('/admin/master/level/user')}}" type="button" class="btn btn-secondary btn-sm me-2">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                                <h3 class="card-title mb-0">Level</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md">
                            <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#orderLevel">Ordering Level</button>
                                
                                <form method="GET" action="{{ url('/admin/master/level/list') }}" class="d-flex flex-wrap align-items-center gap-2">
                                    <div class="input-group input-group-sm mx-1" style="width: 80px;">
                                        <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                            <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm mx-1" style="width: 150px;">
                                        <input type="text" name="table_search mx-1" class="form-control" placeholder="Search" value="{{ request('table_search') }}">
                                        <div class="input-group-append mx-1">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                        
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addLevel">+ Level</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                

                <div class="card-body">  
                    <div class="table-responsive">
                        <div class="table-wrapper" style="overflow-x: auto; border-radius: 10px;">
                            <table id="data" class="table table-bordered table-hover" style="border-radius: 10px; min-width: 900px;">
                              <thead style="background-color: #578FCA; color: white;">
                                <tr>
                                    <th style="min-width: 60px; white-space: nowrap;">No</th>
                                    <th style="min-width: 150px; white-space: nowrap;">Level Name</th>
                                    <th style="min-width: 300px; white-space: nowrap;">Level Description</th>
                                    <th style="min-width: 80px; white-space: nowrap;">Warna</th>
                                    <th style="min-width: 80px; white-space: nowrap;">Urutan</th>
                                    <th style="min-width: 120px; white-space: nowrap;">Action</th>
                                </tr>
                            </thead>
                        <tbody>
                            @if(count($level) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">Data not found</td>
                                </tr>
                            @endif
                            @foreach ($level as $key => $item)
                                <tr>
                                    <td style="white-space: nowrap;">{{ $level->firstItem() + $key }}</td>
                                    <td style="white-space: nowrap;">{{ $item->nama_level }}</td>
                                    <td style="white-space: nowrap; max-width: 300px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->deskripsi_level }}">{{ $item->deskripsi_level }}</td>
                                    <td style="white-space: nowrap;"> <span class="badge" style="background-color: {{ $item->warna }}; width: 30px; height: 20px; display: inline-block; border-radius: 4px;"></span> </td>
                                    <td style="white-space: nowrap;">{{ $item->urutan_level}}</td>
                                    <td style="white-space: nowrap;">
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
