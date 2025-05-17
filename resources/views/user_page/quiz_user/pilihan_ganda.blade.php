@extends('user_page.quiz_user.layout_quiz')
@section('content')
    <div class="row mx-2">


        <div class="col-8 my-3">
            <div class="card shadow" style="max-height: 500px; overflow-y: auto;">
                <div class="card-body p-4">
                    @foreach ($grouped as $soal_id => $items)
                        @php
                            $soal = $items[0];
                        @endphp
                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 fw-bold fs-4">{{ $soal->urutan_soal }}.</div>
                                    <div class="flex-grow-1">{!! $soal->soal !!}</div>
                                </div>

                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    @foreach ($items as $item)
                                        <div class="form-check d-flex align-items-center my-1">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban[{{ $soal_id }}]" value="{{ $item->opsi_id }}"
                                                id="opsi_{{ $item->opsi_id }}">

                                            <label class="form-check-label ms-2" for="opsi_{{ $item->opsi_id }}">
                                                {!! $item->opsi !!}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="col-4 my-3">
            <div class="card mt-1">
                <div class="card-header d-flex  align-items-center">
                    <h3 class="card-title"> {{$quiz_user->judul}} </h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;text-align: center;">
                        <tr>
                            <td class="p-2" style=" width: 25%;">
                                <strong>Jenis Soal</strong>
                                <p> Pilihan Ganda</p>
                            </td>
                            <td class="p-2" style="width: 25%;">
                                <strong>Waktu</strong>
                                <p id="countdown"></p>
                            </td>
                            <td class="p-2" style=" width: 25%;">
                                <strong>Jumlah Soal</strong>
                                <p> {{ $jumlah_soal->jumlah_soal }} </p>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start">
                            <btn type="button" class="btn btn-primary sm" id="btnSelesai" style="border-radius: 5px;">
                                Selesai
                            </btn>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{url('/user/quiz/kerjakan/isian_singkat/'.$quiz_user->quiz_user_id)}}" type="button" class="btn btn-primary sm mx-1" style="border-radius: 5px;">
                                Isian Singkat
                            </a>
                            <a href="{{url('/user/quiz/kerjakan/isian_singkat/'.$quiz_user->quiz_user_id)}}" type="button" class="btn btn-primary sm mx-1" style="border-radius: 5px;">
                                Uraian
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endsection
    @section('script')
        <script>
            // Ambil waktu_selesai dari Laravel (pastikan dalam format ISO)
            let waktuSelesai = new Date("{{ \Carbon\Carbon::parse($quiz_user->waktu_selesai)->toIso8601String() }}");
            let now = new Date();

            console.log(waktuSelesai, now);

            // Update countdown tiap detik
            let countdown = setInterval(function() {
                let now = new Date().getTime();
                let distance = waktuSelesai - now;

                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById("countdown").innerHTML = "Waktu Habis";

                    return;
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    (hours < 10 ? '0' : '') + hours + ":" +
                    (minutes < 10 ? '0' : '') + minutes + ":" +
                    (seconds < 10 ? '0' : '') + seconds;
            }, 1000);
        </script>
    @endsection
