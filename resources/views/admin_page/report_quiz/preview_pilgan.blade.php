@extends('admin_page.layout')
@section('style')
    <style>
        .badge-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #28a745;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 14px;
        }

        .badge-cross {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #dc3545;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="row mx-2 d-flex justify-content-center">


        <div class="col-10 my-3">
            <div class="card shadow" style=" background-color: #f0f4ff8b;">
                <div class="card-header align-items-center row">
                    <div class="d-flex align-items-center col-6">
                        <a href="{{ url('admin/quiz_report/list/'.$id_quiz->quiz_id)}}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Pilihan Ganda</h5>
                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('admin/quiz_report/isian_singkat/'.$id)}}" class="btn btn-primary mx-2" style="border-radius: 5px;">
                            Isian Singkat
                        </a>
                        <a href="{{url('admin/quiz_report/uraian/'.$id)}}" class="btn btn-primary" style="border-radius: 5px;">
                            Uraian
                        </a>
                    </div>
                </div>


                <div class="card-body p-4">
                    @foreach ($soal as $items)
                        @php
                            $soal = $items[0];
                        @endphp

                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 fw-bold fs-4">{{ $items->urutan_soal }}.</div>
                                    <div class="flex-grow-1">{!! $items->soal !!}</div>

                                </div>


                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    Jawab:
                                    {{ $items->opsi }}
                                    @foreach ($items->opsi_jawaban_lengkap as $item)
                                        <div class="form-check d-flex align-items-center my-1">
                                            @if ($item->is_true == 1)
                                                <span class="badge-check mx-1">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                            @else
                                                <span class="badge-cross mx-1">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </span>
                                            @endif

                                            <label class="form-check-label ms-2" for="opsi_{{ $item->opsi_id }}">
                                                {!! $item->opsi !!}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
