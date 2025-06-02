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
                            <div class="col-6">
                                <h3>E book</h3>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-end align-items-center">
                                    <!-- Pagination Dropdown -->
                                    <div class="input-group input-group-sm" style="width: 80px; margin-right: 10px;">
                                        <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                            <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </div>
                                    <!-- Search Box -->
                                    <div class="input-group input-group-sm" style="width: 150px; margin-right: 10px;">
                                        <input type="text" name="table_search" class="form-control" placeholder="Search"
                                            value="{{ request('table_search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Add Button -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addModule">
                                        Add book
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                       <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                        <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                            <thead style="background-color: #578FCA; color: white;">
                                <tr>
                                    <th style="width: 5px">No</th>
                                    <th>Judul</th>
                                    <th>Description</th>
                                    <th>Cover</th>
                                    <th>File</th>
                                    <th>Author</th>
                                    <th>Published</th>
                                    <th>Action</th>
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
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $item->judul }} </td>
                                        <td> {{ $item->deskripsi }} </td>
                                        <td>
                                            @if ($item->tumbnail)
                                                <img src="{{ Storage::url($item->tumbnail) }}" alt=""
                                                    style="width: 100px">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td> <a class="btn btn-primary btn-sm" href="{{ Storage::url($item->url_file) }}"
                                                target="_blank">Lihat File</a> </td>
                                        <td> {{ $item->author }} </td>
                                        <td>
                                            <a class="btn btn-warning btn-edit btn-sm" data-toggle="modal"
                                                data-target="#editModule" data-id="{{ $item->id }}"
                                                data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}"
                                                data-tumbnail="{{ $item->tumbnail }}" data-url="{{ $item->url_file }}"
                                                data-author="{{ $item->author }}">
                                                <i class="fa-solid fa-pencil"></i></a>
                                            <form id="delete-form-{{ $item->id }}" method="POST"
                                                style="display:inline;"
                                                action="{{ url('/admin/module/delete/' . $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $item->id }}"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
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
