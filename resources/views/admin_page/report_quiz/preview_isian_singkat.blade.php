@extends('admin_page.layout')
@section('content')
    <div class="row mx-2 d-flex justify-content-center">


        <div class="col-10 my-3">
            <div class="card shadow" style=" background-color: #f0f4ff8b;">
                <div class="card-header align-items-center row">
                    <div class="d-flex align-items-center col-6">
                        <a href="{{ url('admin/quiz_report/list/'.$id_quiz->quiz_id)}}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Isian Singkat</h5>
                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('admin/quiz_report/pilihan_ganda/'.$id)}}" class="btn btn-primary mx-2" style="border-radius: 5px;">
                           Pilihan Ganda
                        </a>
                        <a href="{{url('admin/quiz_report/uraian/'.$id)}}" class="btn btn-primary" style="border-radius: 5px;">
                            Uraian
                        </a>
                    </div>
                </div>


                <div class="card-body p-4">
                    @foreach ($soal as $items)

                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 fw-bold fs-4">{{ $items->urutan_soal }}.</div>
                                    <div class="flex-grow-1">{!! $items->soal !!}</div>

                                </div>


                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    Jawab:
                                    {{ $items->Jawaban}} </br>
                                    Jawaban Benar :
                                    {{ $items->jawaban_benar}}
                                </div>
                            </div>
                        </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
