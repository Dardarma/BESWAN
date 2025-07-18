@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div
                    class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h3 class="card-title mb-2 mb-md-0">Report Quiz</h3>
                    <div
                        class="card-tools d-flex flex-column flex-md-row align-items-start align-items-md-center w-100 w-md-auto">

                        <form method="GET" action="{{ url('/admin/quiz') }}"
                            class="d-flex flex-column flex-md-row align-items-start align-items-md-center w-100 w-md-auto m-1">
                            <!-- Pagination Dropdown -->
                            <div class="input-group input-group-sm mb-2 mb-md-0 m-1" style="width: 80px;">
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
                                    <button type="submit" class="btn btn-default ">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-wrapper" style="overflow-x: auto; border-radius: 10px;">
                        <table id="data" class="table table-bordered table-hover"
                            style="border-radius: 10px; min-width: 800px; white-space: nowrap;">
                            <thead style="background-color: #578FCA; color: white;">
                                <tr>
                                    <th style="width: 5vw">No</th>
                                    <th style="width: 20vw">Judul Quiz</th>
                                    <th style="width: 20vw">Judul Materi</th>
                                    <th style="width: 20vw">Level</th>
                                    <th style="width: 6vw">Jumlah Soal</th>
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
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $item->judul }} </td>
                                        <td> {{ $item->materi_judul }} </td>
                                        <td> {{ $item->nama_level }} </td>
                                        <td> {{ $item->jumlah_soal }} </td>
                                        <td>
                                            <a href="{{ url('/admin/quiz_report/list/' . $item->quiz_id) }}"
                                                class="btn btn-info btn-sm m-1">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
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
                            <p>Showing {{ $quiz->firstItem() }} to {{ $quiz->lastItem() }} of
                                {{ $quiz->total() }}
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
@endsection

@section('script')
    <script></script>
@endsection
