@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-14">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="col-1 m-0 p-0 text-end">
                        
                    </div>
                    

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <div class="col-1 m-0 p-0 text-end">
                        <a href="{{ url('/user/quiz/') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <h3 class="card-title"> {{ $quiz->judul_quiz }} </h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;">
                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Materi</strong>
                                <p>{{ $quiz->judul_materi }} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Waktu Pengerjaan</strong>
                                <p> {{ $quiz->waktu_pengerjaan }} Menit</p>
                            </td>
                            @foreach ($type_soal as $type)
                                <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                    <strong> {{ $type->tipe_soal }} </strong>
                                    <p> {{ $type->jumlah_soal }} </p>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                      <!-- Hidden Form -->
                        <form id="start-quiz-form" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <!-- Tombol di mana saja -->
                        <button class="btn-kerjakan btn-info btn-sm" data-quiz-id="{{ $quiz->id }}">Mulai Quiz</button>
                    </div>

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
                            <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                                <thead style="background-color: #578FCA; color: white;">
                                    <tr>
                                        <td>No</td>
                                        <td>Tanggal Pengerjaan</td>
                                        <td>Jawaban Benar</td>
                                        <td>Jawaban Salah</td>
                                        <td>Nilai</td>
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
                                            <td>{{ $item->jawaban_benar }}</td>
                                            <td>{{ $item->jawaban_salah }}</td>
                                            <td>{{ $item->nilai }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.btn-kerjakan').forEach(function(button){
            button.addEventListener('click', function(event){
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
                        form.setAttribute('action', '/user/quiz/start/' + button.dataset.quizId);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@section('script')
@endsection
