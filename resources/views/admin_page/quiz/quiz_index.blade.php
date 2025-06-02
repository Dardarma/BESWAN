@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Quiz</h3>
                    <div class="card-tools d-flex align-items-center ml-auto">
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
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addQuiz">Add
                            Quiz</button>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                        <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                            <thead style="background-color: #578FCA; color: white;">
                                <tr>
                                    <th style="width: 5vw">No</th>
                                    <th style="width: 20vw">Judul Quiz</th>
                                    <th style="width: 20vw">Level</th>
                                    <th style="width: 20vw">Materi</th>
                                    <th style="width: 8vw">Action</th>
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
                                        <td>{{ $quiz->firstItem() + $key }}</td>
                                        <td> {{ $item->judul }} </td>
                                        <td> {{ $item->nama_level }} </td>
                                        <td> {{ $item->materi_judul ?? '-' }} </td>
                                        <td>
                                            <a class="btn btn-primary btn-edit btn-sm"
                                                href="{{ url('/admin/quiz/' . $item->quiz_id) }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if($item->type == 'posttest')
                                            <form id="delete-form-{{ $item->quiz_id }}" method="POST"
                                                style="display:inline;"
                                                action="{{ url('/admin/quiz/delete/' . $item->quiz_id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
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
