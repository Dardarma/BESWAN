@extends('admin_page.layout')
@section('style')
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h3 class="card-title">Video</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/admin/feed') }}" class="d-flex align-items-center">
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
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add">Add
                                Video</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-wrapper" style="border-radius: 10px; overflow: hidden;">
                            <table id="data" class="table table-bordered table-hover" style="margin-bottom: 0;">
                                <thead style="background-color: #578FCA; color: white;">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Materi</th>
                                        <th>Deskripsi</th>
                                        <th>video</th>
                                        <th>Thumbnail</th>
                                        <th>Uploaded By</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($video as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->judul_materi }} </td>
                                            <td> {{ $item->deskripsi }} </td>
                                            <td>
                                                @if ($item->url_video)
                                                    <a href="{{ $item->url_video }}" target="_blank">
                                                        Lihat Video
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->url_video)
                                                    <img src="https://img.youtube.com/vi/{{ Str::before(Str::afterLast($item->url_video, '/'), '?') }}/hqdefault.jpg"
                                                        alt="{{ $item->judul }}" width="120" height="90">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $item->updated_by }}</td>
                                            <td>
                                                <a class="btn btn-warning btn-edit btn-sm" data-toggle="modal"
                                                    data-target="#edit" data-id="{{ $item->id }}"
                                                    data-id_materi="{{ $item->id_materi }}"
                                                    data-deskripsi="{{ $item->judul_materi }}"
                                                    data-url="{{ $item->url_video }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" method="POST"
                                                    style="display:inline;"
                                                    action="{{ url('/admin/video/delete/' . $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
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
        @include('admin_page.video.add')
        @include('admin_page.video.edit')
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
                            document.getElementById(`delete-form-${formId}`)
                        .submit(); // 🔥 ID form sudah sesuai
                        }
                    });
                });
            });
        });


        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let idMateri = $(this).data('id_materi');
            let deskripsi = $(this).data('deskripsi');
            let url = $(this).data('url');

            $('#edit').find('form').attr('action', '/admin/video/update/' + id);

            $('#edit').find('input[name="id"]').val(id);
            $('#edit').find('select[name="id_materi"]').val(idMateri);
            $('#edit').find('input[name="deskripsi"]').val(deskripsi);
            $('#edit').find('input[name="url_video"]').val(url);

            $('#edit').modal('show');
        });
    </script>
@endsection
