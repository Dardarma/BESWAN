@extends('user_page.layout')
@section('style')
    <style>
        .custom-card {
            color: white;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 80%;
        }

        .icon {
            font-size: 30px;
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
    </style>
@endsection
@section('content')
    <div class="container mt-5 text-center">
        <h1>Pilih materi</h1>

        <div class="row">

            <div class="container my-5 mx-2">
                <div class="row">
                    @foreach ($quiz as $item)
                        <div class="card-body col-md-3 col-6 mx-2"
                            style="background-color: blue; border-radius: 10px; padding: 10px; color:white; cursor: pointer;"
                            onclick="window.location.href='{{ url('user/quiz/' . $item->id) }}'">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-book-open icon mx-2"></i>
                                <h5 class="mx-2"> {{ $item->judul_quiz }} </h5>
                            </div>
                            <div class="card-text d-flex justify-content-start align-items-center my-2">
                                <table>
                                    <tr>
                                        <td>Materi</td>
                                        <td>:</td>
                                        <td> {{ $item->judul_materi }} </td>
                                    </tr>
                                    <tr>
                                        <td>Waktu</td>
                                        <td>:</td>
                                        <td> {{ $item->waktu_pengerjaan }} </td>
                                    </tr>
                                    @foreach ($q->type_soal as $type)
                                        @php
                                            if ($type->tipe_soal == 'pilihan_ganda') {
                                                $type->tipe_soal = 'Pilihan Ganda';
                                            } elseif ($type->tipe_soal == 'isian_singkat') {
                                                $type->tipe_soal = 'Isian Singkat';
                                            } else {
                                                $type->tipe_soal = 'Esai';
                                            }
                                        @endphp
                                        <tr>
                                            <td> {{ $type->tipe_soal }} </td>
                                            <td>:</td>
                                            <td> {{ $type->jumlah_soal }} </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
