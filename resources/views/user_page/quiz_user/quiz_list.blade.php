@extends('user_page.layout')
@section('style')
    <style>
        .icon {
            font-size: 30px;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .icon-container {
            flex: 2;
            /* Rasio 2 */
            display: flex;
            justify-content: center;
        }

        .text-content {
            flex: 5;
            /* Rasio 3 */
            text-align: left;
        }

        .download-icon {
            font-size: 20px;
            color: white;
        }

        /* Quiz card table styles */
        .card-text table {
            width: 100%;
            text-align: left;
        }

        .card-text table td {
            text-align: left;
            padding: 2px 0;
            vertical-align: top;
        }

        .card-text table td:first-child {
            width: 30%;
        }

        .card-text table td:nth-child(2) {
            width: 5%;
        }

        .card-text table td:last-child {
            width: 65%;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Quiz</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/user/quiz') }}"
                                class="d-flex flex-column flex-md-row align-items-stretch w-100">
                                <div class="input-group input-group-sm mb-2 mr-md-2" style="width: 100%; max-width: 80px;">
                                    <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                        <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mb-2 mr-md-2" style="width: 100%; max-width: 120px;">
                                    <select class="custom-select" name="level" onchange="this.form.submit()">
                                        <option value="">Semua Level</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}"
                                                {{ request('level') == $level->id ? 'selected' : '' }}>
                                                {{ $level->nama_level }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mb-2 mr-md-2" style="width: 100%; max-width: 150px;">
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
                        <div class="row  ">
                            @foreach ($quiz as $item)
                                <div class="card-body col-md-3 col-12 m-2 custom-card justify-content-center"
                                    style="background-color: {{ $item->warna }} ; border-radius: 10px; padding: 10px; color:white; cursor: pointer;"
                                    onclick="window.location.href='{{ url('user/quiz/' . $item->id) }}'">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-book-open icon mx-2"></i>
                                        <h5 class="mx-2"> {{ $item->judul_quiz }} </h5>
                                    </div>
                                    <div class="card-text d-flex justify-content-start align-items-center my-2">
                                        <table style="width: 100%; text-align: left;">
                                            <tr>
                                                <td style="width: 50%; text-align: left;">Materi</td>
                                                <td style="width: 5%; text-align: left;">:</td>
                                                <td style="width: 45%; text-align: left;"> {{ $item->judul_materi }} </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">Waktu</td>
                                                <td style="text-align: left;">:</td>
                                                <td style="text-align: left;"> {{ $item->waktu_pengerjaan }} menit</td>
                                            </tr>
                                            @if (isset($item->type_soal))
                                                @foreach ($item->type_soal as $type)
                                                    @php
                                                        if ($type->tipe_soal == 'pilihan_ganda') {
                                                            $type->tipe_soal = 'Pilihan Ganda';
                                                        } elseif ($type->tipe_soal == 'isian_singkat') {
                                                            $type->tipe_soal = 'Isian Singkat';
                                                        } else {
                                                            $type->tipe_soal = 'Esai';
                                                        }
                                                    @endphp <tr>
                                                        <td style="text-align: left;"> {{ $type->tipe_soal }} </td>
                                                        <td style="text-align: left;">:</td>
                                                        <td style="text-align: left;"> {{ $type->jumlah_soal }} </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            @endforeach
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

        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
