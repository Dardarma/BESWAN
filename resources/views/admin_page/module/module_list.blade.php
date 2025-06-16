@extends('admin_page.layout')
@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-auto mb-2 mb-md-0">
                                <h3 class="card-title mb-0">E book</h3>
                            </div>
                            <div class="col-12 col-md">
                                <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                                    <form method="GET" action="{{ url('/admin/module') }}" class="d-flex flex-wrap align-items-center gap-2 m-1">
                                        <!-- Pagination Dropdown -->
                                        <div class="input-group input-group-sm" style="width: 80px;">
                                            <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                                <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                        </div>
                                        <!-- Search Box -->
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control" placeholder="Search"
                                                value="{{ request('table_search') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Add Button -->
                                    <button type="button" class="btn btn-info btn-sm m-1" data-toggle="modal" data-target="#addModule">
                                        Add book
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                       <div class="table-responsive">
                           <div class="table-wrapper" style="overflow-x: auto; border-radius: 10px;">
                            <table id="data" class="table table-bordered table-hover" style="border-radius: 10px; min-width: 1100px;">
                                <thead style="background-color: #578FCA; color: white;">
                                    <tr>
                                        <th style="min-width: 60px; white-space: nowrap;">No</th>
                                        <th style="min-width: 200px; white-space: nowrap;">Judul</th>
                                        <th style="min-width: 250px; white-space: nowrap;">Description</th>
                                        <th style="min-width: 120px; white-space: nowrap;">Cover</th>
                                        <th style="min-width: 100px; white-space: nowrap;">File</th>
                                        <th style="min-width: 120px; white-space: nowrap;">Author</th>
                                        <th style="min-width: 120px; white-space: nowrap;">Published</th>
                                        <th style="min-width: 150px; white-space: nowrap;">Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @if (count($modul) == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">Data not found</td>
                                    </tr>
                                @endif
                                @foreach ($modul as $key => $item)
                                    <tr>
                                        <td style="white-space: nowrap;"> {{ $key + 1 }} </td>
                                        <td style="white-space: nowrap; max-width: 200px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->judul }}"> {{ $item->judul }} </td>
                                        <td style="white-space: nowrap; max-width: 250px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->deskripsi }}"> {{ $item->deskripsi }} </td>
                                        <td style="white-space: nowrap;">
                                            @if ($item->tumbnail)
                                                <img src="{{ Storage::url($item->tumbnail) }}" alt=""
                                                    style="width: 100px; height: auto; border-radius: 5px;">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="white-space: nowrap;"> <a class="btn btn-primary btn-sm" href="{{ Storage::url($item->url_file) }}"
                                                target="_blank">Lihat File</a> </td>
                                        <td style="white-space: nowrap;"> {{ $item->author }} </td>
                                        <td style="white-space: nowrap;"> {{$item->terbitan}} </td>
                                        <td style="white-space: nowrap;">
                                            <a class="btn btn-warning btn-edit btn-sm m-1" data-toggle="modal"
                                                data-target="#editModule" data-id="{{ $item->id }}"
                                                data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}"
                                                data-tumbnail="{{ $item->tumbnail }}" data-url="{{ $item->url_file }}"
                                                data-author="{{ $item->author }}">
                                                <i class="fa-solid fa-pencil"></i></a>
                                            <form id="delete-form-{{ $item->id }}" method="POST"
                                                style="display:inline;" class="m-1"
                                                action="{{ url('/admin/module/delete/' . $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete m-1"
                                                    data-id="{{ $item->id }}"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @include('admin_page.module.module_add')
        @include('admin_page.module.module_edit')
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');
                let judul = $(this).data('judul');
                let deskripsi = $(this).data('deskripsi');
                let tumbnail = $(this).data('tumbnail');
                let url_file = $(this).data('url_file');
                let author = $(this).data('author');

                $('#editModule').find('form').attr('action', '/admin/module/update/' + id);

                $('#editModule').find('input[name="id"]').val(id);
                $('#editModule').find('input[name="judul"]').val(judul);
                $('#editModule').find('textarea[name="deskripsi"]').val(deskripsi);
                $('#editModule').find('input[name="tumbnail"]').val('');
                $('#editModule').find('input[name="url_file"]').val('');
                $('#editModule').find('input[name="author"]').val(author);


            })
            $('editModule').modal('show');
        })

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(function(button) {
                button.addEventListener('click', function() {
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
                            document.getElementById('delete-form-' + formId).submit();
                        }
                    })
                })
            })
        })
    </script>
@endsection
