@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <div class="col-1 m-0 p-0 text-end">
                        <a href="{{ url('/admin/quiz_report') }}" class="btn btn-secondary"><i
                                class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <h3 class="card-title"> {{ $quiz->judul_quiz ?? 'Pretest' }} </h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;">
                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 20%;">
                                <strong>Materi</strong>
                                <p>{{ $quiz->materi_judul ?? "pretest" }} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 20%;">
                                <strong>Level</strong>
                                <p>{{ $quiz->nama_level }}</p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 20%;">
                                <strong>Waktu Pengerjaan</strong>
                                <p> {{ $quiz->waktu_pengerjaan }} Menit</p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 20%;">
                                <strong>Jumlah Soal</strong>
                                <p>{{ $quiz->jumlah_soal }} Soal</p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 20%;">
                                <strong>Waktu pengerjaan</strong>
                                <p>{{ $quiz->jumlah_quiz }} Quiz</p>
                            </td>

                        </tr>
                    </table>


                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <h3 class="card-title">Report Nilai</h3>
                    <div class="card-tools d-flex align-items-center ml-auto">

                        <form method="GET" action="{{ url('/admin/master/level/list') }}"
                            class="d-flex align-items-center">
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

                    </div>
                </div>



                <div class="card-body">
                    <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                        <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                            <thead style="background-color: #578FCA; color: white;">
                                <tr>
                                    <th style="width: 5vw">No</th>
                                    <th style="width: 20vw">Nama</th>
                                    <th style="width: 20vw">Status</th>
                                    <th style="width: 6vw">Nilai</th>
                                    <th style="width: 8vw">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($quiz_user) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">Data not found</td>
                                    </tr>
                                @endif
                                @foreach ($quiz_user as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->status }} </td>
                                        <td> {{ $item->nilai_persen }}
                                        <td>
                                            <a href="{{ url("/redirect_report/".$item->quiz_user_id) }}"
                                                class="btn btn-info btn-sm">
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
                    @if (count($quiz_user) == 0)
                        <div class="col-auto m-2">
                            <p>Showing 0 to 0 of 0 entries</p>
                        </div>
                    @else
                        <div class="col-auto m-2">
                            <p>Showing {{ $quiz_user->firstItem() }} to {{ $quiz_user->lastItem() }} of
                                {{ $quiz_user->total() }}
                                entries</p>
                        </div>
                        <div class="col-auto m-2">
                            {{ $quiz_user->links() }}
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
