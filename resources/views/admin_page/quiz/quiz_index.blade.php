@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <h3 class="card-title mb-0">Quiz</h3>
                        </div>
                        <div class="col-12 col-md">
                            <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                                <form method="GET" action="{{ url('/admin/quiz') }}" class="d-flex flex-wrap align-items-center gap-2 m-1">
                                    <!-- Pagination Dropdown -->
                                    <div class="input-group input-group-sm m-1" style="width: 80px;">
                                        <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                            <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm m-1" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control" placeholder="Search"
                                            value="{{ request('table_search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default m-1">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Add Level Button -->
                                <button type="button" class="btn btn-info btn-sm m-1" data-toggle="modal" data-target="#addQuiz">Add
                                    Quiz</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-wrapper" style="overflow-x: auto; border-radius: 10px;">
                            <table id="data" class="table table-bordered table-hover" style="border-radius: 10px; min-width: 800px;">
                                <thead style="background-color: #578FCA; color: white;">
                                    <tr>
                                        <th style="min-width: 60px; white-space: nowrap;">No</th>
                                        <th style="min-width: 200px; white-space: nowrap;">Judul Quiz</th>
                                        <th style="min-width: 150px; white-space: nowrap;">Level</th>
                                        <th style="min-width: 200px; white-space: nowrap;">Materi</th>
                                        <th style="min-width: 150px; white-space: nowrap;">Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @if (count($quiz) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">Data not found</td>
                                    </tr>
                                @endif
                                @foreach ($quiz as $key => $item)
                                    <tr>
                                        <td style="white-space: nowrap;">{{ $quiz->firstItem() + $key }}</td>
                                        <td style="white-space: nowrap; max-width: 200px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->judul }}"> {{ $item->judul }} </td>
                                        <td style="white-space: nowrap;"> {{ $item->nama_level }} </td>
                                        <td style="white-space: nowrap; max-width: 200px; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->materi_judul ?? '-' }}"> {{ $item->materi_judul ?? '-' }} </td>
                                        <td style="white-space: nowrap;">
                                            <a class="btn btn-primary btn-edit btn-sm m-1"
                                                href="{{ url('/admin/quiz/' . $item->quiz_id) }}">
                                                <i class="fa-solid fa-gear"></i>
                                            </a>
                                            @if($item->type == 'posttest')
                                            <form id="delete-form-{{ $item->quiz_id }}" method="POST"
                                                style="display:inline;" class="m-1"
                                                action="{{ url('/admin/quiz/delete/' . $item->quiz_id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete m-1"
                                                    data-id="{{ $item->quiz_id }}"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-end">
                    @if (count($quiz) == 0)
                        <div class="col-auto m-2">
                            <p>Showing 0 to 0 of 0 entries</p>
                        </div>
                    @else
                        <div class="col-auto m-2">
                            <p>Showing {{ $quiz->firstItem() }} to {{ $quiz->lastItem() }} of {{ $quiz->total() }}
                                entries</p>
                        </div>
                        <div class="col-auto m-2">
                            {{ $quiz->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    @include('admin_page.quiz.quiz_add_modal')
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
                    }) // <-- penutupan missing here
                })
            })
        })
    </script>
@endsection
