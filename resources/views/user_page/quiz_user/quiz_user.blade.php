@extends('user_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <div class="col-1 m-3 p-1 text-end mx-0">
                        <a href="{{ url('/user/quiz/') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <h3 class="card-title"> {{ $quiz->judul_quiz }} </h3>
                </div>
                <div class="card-body">

                    <table class="quiz-info-table" style="width: 100%; table-layout: fixed;background-color: #AADDFF;">
                        <tr>
                            <td class="p-2 quiz-info-cell" style="background-color: #AADDFF; width: 25%;">
                                <strong class="quiz-info-label">Materi</strong>
                                <p class="quiz-info-value">{{ $quiz->judul_materi ?? '-' }} </p>
                            </td>
                            <td class="p-2 quiz-info-cell" style="background-color: #AADDFF; width: 25%;">
                                <strong class="quiz-info-label">Waktu </strong>
                                <p class="quiz-info-value"> {{ $quiz->waktu_pengerjaan }} Menit</p>
                            </td>
                            @foreach ($type_soal as $type)
                                @php
                                    if ($type->tipe_soal == 'pilihan_ganda') {
                                        $tipe_display = 'Pilihan Ganda';
                                    } elseif ($type->tipe_soal == 'isian_singkat') {
                                        $tipe_display = 'Isian';
                                    } else {
                                        $tipe_display = 'Esai';
                                    }
                                @endphp
                                <td class="p-2 quiz-info-cell" style="background-color: #AADDFF; width: 25%;">
                                    <strong class="quiz-info-label"> {{ $tipe_display }} </strong>
                                    <p class="quiz-info-value"> {{ $type->jumlah_soal }} </p>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                    @if ($quiz->type == 'posttest')
                        <div class="d-flex justify-content-end mt-3">
                            <!-- Hidden Form -->
                            <form id="start-quiz-form" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <!-- Tombol di mana saja -->
                            <button class="btn-kerjakan btn-info btn-sm" data-quiz-id="{{ $quiz->id }}">Mulai
                                Quiz</button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-12">
            <d class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <h3 class="card-title">Hasil Quiz</h3>
                </div>
                <div class="card-body">
                    <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                        <div style="overflow-x: auto; width: 100%;">
                            <table id="data" class="table table-bordered table-hover"
                                style="border-radius: 10px; min-width: 600px;">
                                <thead style="background-color: #578FCA; color: white;">
                                    <tr>
                                        <td>No</td>
                                        <td>Tanggal Pengerjaan</td>
                                        <td>Nilai</td>
                                        <td>Status</td>
                                        <td style="width: 5px">Preview Jawaban</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($quiz_user->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada hasil quiz</td>
                                        </tr>
                                    @endif
                                    @foreach ($quiz_user as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->Waktu_mulai)->format('d-m-Y') }}</td>
                                            <td> {{ $item->nilai_persen }} </td>
                                            <td> {{ $item->status }} </td>
                                            <td>
                                                <a href="{{ url('/redirect_report/' . $item->id) }}"
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

                </div>
        </div>
    @endsection

    <style>
        /* CSS untuk responsive table quiz info */
        @media (max-width: 767px) {

            .quiz-info-table,
            .quiz-info-table tr,
            .quiz-info-table td {
                display: block !important;
                width: 100% !important;
            }

            .quiz-info-cell {
                margin-bottom: 10px !important;
                border-radius: 5px !important;
            }

            .quiz-info-label::after {
                content: ": ";
            }

            .quiz-info-label,
            .quiz-info-value {
                display: inline !important;
                margin: 0 !important;
            }

            .quiz-info-value {
                margin-left: 5px !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-kerjakan').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Anda akan mengerjakan quiz ini",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, kerjakan!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('start-quiz-form');
                            form.setAttribute('action', '/user/quiz/start/' + button.dataset
                                .quizId);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @section('script')
    @endsection
