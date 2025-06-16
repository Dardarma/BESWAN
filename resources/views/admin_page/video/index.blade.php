@extends('admin_page.layout')
@section('style')
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-auto mb-2 mb-md-0">
                                <h3 class="card-title mb-0">Video</h3>
                            </div>
                            <div class="col-12 col-md">
                                <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                                    <form method="GET" action="{{ url('/admin/feed') }}" class="d-flex flex-wrap align-items-center gap-2 m-1">
                                        <div class="input-group input-group-sm m-1" style="width: 80px;">
                                            <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                                <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100
                                                </option>
                                            </select>
                                        </div>

                                        <div class="input-group input-group-sm m-1" style="width: 150px;">
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
                                    <button type="button" class="btn btn-info btn-sm m-1" data-toggle="modal" data-target="#add">Add
                                        Video</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-wrapper" style="border-radius: 10px; overflow-x: auto;">
                                <table id="data" class="table table-bordered table-hover" style="margin-bottom: 0; min-width: 1200px;">
                                    <thead style="background-color: #578FCA; color: white;">
                                        <tr>
                                            <th style="min-width: 60px; white-space: nowrap;">No</th>
                                            <th style="min-width: 200px; white-space: nowrap;">Material Title</th>
                                            <th style="min-width: 250px; white-space: nowrap;">Description</th>
                                            <th style="min-width: 80px; white-space: nowrap;">Video</th>
                                            <th style="min-width: 150px; white-space: nowrap;">Thumbnail</th>
                                            <th style="min-width: 120px; white-space: nowrap;">Uploaded By</th>
                                            <th style="min-width: 150px; white-space: nowrap;">Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    @if (count($video) == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">Data not found</td>
                                        </tr>
                                    @endif
                                    @foreach ($video as $key => $item)
                                        <tr>
                                            <td style="white-space: nowrap;"> {{ $key + 1 }} </td>
                                            <td style="white-space: nowrap; max-width: 200px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->judul_materi }}"> {{ $item->judul_materi }} </td>
                                            <td style="white-space: nowrap; max-width: 250px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->deskripsi }}"> {{ $item->deskripsi }} </td>
                                            <td style="white-space: nowrap;">
                                                @if ($item->url_video)
                                                    <a href="{{ $item->url_video }}" class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fa-brands fa-youtube"></i>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap;">
                                                @if ($item->url_video)
                                                    <img src="https://img.youtube.com/vi/{{ Str::before(Str::afterLast($item->url_video, '/'), '?') }}/hqdefault.jpg"
                                                        alt="{{ $item->judul }}" width="120" height="90" style="border-radius: 5px;">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap;">{{ $item->updated_by }}</td>
                                            <td style="white-space: nowrap;">
                                                <a class="btn btn-warning btn-edit btn-sm m-1" data-toggle="modal"
                                                    data-target="#edit" data-id="{{ $item->id }}"
                                                    data-id_materi="{{ $item->id_materi }}"
                                                    data-deskripsi="{{ $item->judul_materi }}"
                                                    data-url="{{ $item->url_video }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" method="POST"
                                                    style="display:inline;" class="m-1"
                                                    action="{{ url('/admin/video/delete/' . $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete m-1"
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
                        <div class="row justify-content-end">
                            @if (count($video) == 0)
                                <div class="col-auto m-2">
                                    <p>Showing 0 to 0 of 0 entries</p>
                                </div>
                            @else
                                <div class="col-auto m-2">
                                    <p>Showing {{ $video->firstItem() }} to {{ $video->lastItem() }} of
                                        {{ $video->total() }}
                                        entries</p>
                                </div>
                                <div class="col-auto m-2">
                                    {{ $video->links() }}
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
