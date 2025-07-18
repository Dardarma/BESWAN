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
        {{-- {{dd($tipe_tersedia)}} --}}
        <div class="col-10 my-3">
            <div class="card shadow" style=" background-color: #f0f4ff8b;">
                <div class="card-header align-items-center row">
                    <div class="d-flex align-items-center col-6">
                        <a href="{{ url('admin/quiz_report/list/' . $id_quiz->quiz_id) }}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Pilihan Ganda</h5>

                    </div>
                    <div class="col-6 d-flex justify-content-end">

                        @if (in_array('isian_singkat', $tipe_tersedia))
                            <a href="{{ url('admin/quiz_report/isian_singkat/' . $id) }}" class="btn btn-primary mx-2"
                                style="border-radius: 5px;">
                                Isian Singkat
                            </a>
                        @endif
                        @if (in_array('uraian', $tipe_tersedia))
                            <a href="{{ url('admin/quiz_report/uraian/' . $id) }}" class="btn btn-primary"
                                style="border-radius: 5px;">
                                Uraian
                            </a>
                        @endif
                    </div>
                </div>


                <div class="card-body p-4">
                    @foreach ($soal as $items)
                        @php
                            $soal = $items[0];
                        @endphp

                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                <div class="d-flex align-items-start">
                                    <div class="me-3 fw-bold fs-4">{{ $items->urutan_soal }}.</div>
                                    <div class="flex-grow-1">
                                        <div class="mb-3 p-0">
                                            {!! $items->soal !!}
                                        </div>
                                        @if (isset($items->media_soal) && count($items->media_soal) > 0)
                                            <div class="row">
                                                @foreach ($items->media_soal as $media)
                                                    @if ($media->type_media == 'image')
                                                        <div class="col-4 mt-2">
                                                            <img src="{{ asset('storage/' . $media->media) }}"
                                                                class="img-fluid rounded" alt="Media Soal">
                                                        </div>
                                                    @elseif($media->type_media == 'audio')
                                                        <div class="col-12 mb-2">
                                                            <audio controls>
                                                                <source src="{{ asset('storage/' . $media->media) }}"
                                                                    type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        </div>
                                                    @elseif($media->type_media == 'video')
                                                        <div class="col-12 mb-2">
                                                            <video controls class="img-fluid rounded">
                                                                <source src="{{ asset('storage/' . $media->media) }}"
                                                                    type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <input type="hidden" name="soal_terpilih_id" value="{{ $items->soal_terpilih_id }}">
                                </div>
                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    Jawab:
                                    <div class="d-flex align-items-center">
                                        @if ($items->opsi == null)
                                            <span class="badge-cross mx-1">
                                                <i class="fa-solid fa-xmark"></i>
                                            </span>
                                            <span class="text-danger">Tidak ada jawaban</span>
                                        @else
                                            @if ($items->is_true == 1)
                                                <span class="badge-check mx-1">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                            @else
                                                <span class="badge-cross mx-1">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </span>
                                            @endif
                                            <span class="ms-2">{{ $items->opsi }}</span>
                                        @endif
                                    </div>
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
