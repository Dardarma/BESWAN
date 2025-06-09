@extends('user_page.quiz_user.layout_quiz')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    @if(Auth::user()->level_murid)
                    <div class="col-1 m-0 p-0 text-end">
                        <a href="{{ url('/user/quiz/') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    @endif
                    <h3 class="card-title"> {{ $quiz->judul}} </h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed; mx-2">
                        <tr>
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
