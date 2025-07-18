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
                        <a href="{{ url('admin/quiz_report/list/' . $id_quiz->quiz_id) }}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Isian Singkat</h5>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        @if (in_array('pilihan_ganda', $tipe_tersedia))
                            <a href="{{ url('admin/quiz_report/pilihan_ganda/' . $id) }}" class="btn btn-primary mx-2"
                                style="border-radius: 5px;">
                                Pilihan Ganda
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
                    @foreach ($soal as $item)
                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 fw-bold fs-4">{{ $item->urutan_soal }}.</div>
                                    <div class="flex-grow-1">{!! $item->soal !!}</div>
                                </div>
                                @if ($item->media_soal && $item->media_soal->count() > 0)
                                    <div class="row">
                                        @foreach ($item->media_soal as $media)
                                            @if ($media->type_media == 'image')
                                                <div class="col-4 mb-2 mx-1 d-flex justify-content-center align-items-center"
                                                    style="overflow: hidden;">
                                                    <img src="{{ asset('storage/' . $media->media) }}"
                                                        class="img-fluid rounded" alt="Media Soal"
                                                        style="max-width: 100%; max-height: 150px;">
                                                </div>
                                            @elseif($media->type_media == 'audio')
                                                <div
                                                    class="col-4 mb-2 mx-1 d-flex justify-content-center align-items-center">
                                                    <audio controls style="max-width: 100%; max-height: 50px;">
                                                        <source src="{{ asset('storage/' . $media->media) }}"
                                                            type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                            @elseif($media->type_media == 'video')
                                                <div class="col-4 mb-2 mx-1 d-flex justify-content-center align-items-center"
                                                    style="overflow: hidden;">
                                                    <video controls class="img-fluid rounded"
                                                        style="max-width: 100%; max-height: 150px;">
                                                        <source src="{{ asset('storage/' . $media->media) }}"
                                                            type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    Jawab:
                                    <div class="d-flex align-items-center">
                                        @if ($item->jawaban == null)
                                            <span class="badge-cross mx-1">
                                                <i class="fa-solid fa-xmark"></i>
                                            </span>
                                            <span class="text-danger ms-2">Tidak ada jawaban</span>
                                        @else
                                            @if ($item->status_jawaban_akhir == 'benar')
                                                <span class="badge-check mx-1">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                            @else
                                                <span class="badge-cross mx-1">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </span>
                                            @endif
                                            <span class="ms-2">{{ $item->jawaban }}</span>
                                        @endif
                                    </div>
                                    Jawaban Benar :
                                    {{ $item->jawaban_benar }}
                                </div>
                            </div>
                        </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
