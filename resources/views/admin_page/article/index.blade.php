@extends('admin_page.layout')
@section('style')
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h3 class="card-title">Materi</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/admin/article') }}" class="d-flex align-items-center">
                                <div class="input-group input-group-sm" style="width: 80px; margin-right: 10px;">
                                    <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                        <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <div class="input-group input-group-sm" style="width: 150px; margin-right: 10px;">
                                    <input type="text" name="table_search" class="form-control" placeholder="Search"
                                        value="{{ request('table_search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Add Level Button -->
                            <a href="{{ url('/admin/article/create') }}" type="button" class="btn btn-info btn-sm">Add
                                Materi</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                            <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                                <thead style="background-color: #578FCA; color: white;">
                                    <tr>
                                        <th style="width:5vw">No</th>
                                        <th style="width: 20vw;">Title</th>
                                        <th style="width: 35vw;">Description</th>
                                        <th style="width:5vw">Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($article) == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">Data not found</td>
                                        </tr>
                                    @endif
                                    @foreach ($article as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->judul }} </td>
                                            <td> {{ $item->deskripsi }} </td>
                                            <td> {{ $item->level->urutan_level }} </td>
                                            <td>
                                                <a class="btn btn-primary btn-edit btn-sm"
                                                    href="{{ url('/admin/article/edit/' . $item->id) }}">
                                                    <i class="fa-solid fa-gear"></i>
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" method="POST"
                                                    style="display:inline;"
                                                    action="{{ url('/admin/article/delete/' . $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-id="{{ $item->id }}"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                </form>
                                                <a class="btn btn-primary btn-edit btn-sm"
                                                    href="{{ url('/user/materi/comment/'.$item->id) }}">
                                                    <img src="{{ asset('icon/Putih/Add Comment Putih.svg') }}" alt="Comment"
                                                        style="width: 20px; height: 20px;">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="row justify-content-end">
                            @if (count($article) == 0)
                                <div class="col-auto m-2">
                                    <p>Showing 0 to 0 of 0 entries</p>
                                </div>
                            @else
                                <div class="col-auto m-2">
                                    <p>Showing {{ $article->firstItem() }} to {{ $article->lastItem() }} of
                                        {{ $article->total() }}
                                        entries</p>
                                </div>
                                <div class="col-auto m-2">
                                    {{ $article->links() }}
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

    </div>
@endsection
@section('script')
    <script>
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
