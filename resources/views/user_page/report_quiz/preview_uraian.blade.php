@extends('user_page.layout')
@section('content')
    <div class="row mx-2 d-flex justify-content-center">


        <div class="col-10 my-3">
            <div class="card shadow" style=" background-color: #f0f4ff8b;">
                <div class="card-header align-items-center row">
                    <div class="d-flex align-items-center col-6">
                        <a href="{{ url('user/quiz/' . $id_quiz->quiz_id) }}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Uraian</h5>
                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url('user/quiz_report/isian_singkat/' . $id) }}" class="btn btn-primary mx-2"
                            style="border-radius: 5px;">
                            Isian Singkat
                        </a>
                        <a href="{{ url('user/quiz_report/pilihan_ganda/' . $id) }}" class="btn btn-primary"
                            style="border-radius: 5px;">
                            Pilihan Ganda
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
                                    @if ($items->media_soal && $items->media_soal->count() > 0)
                                        <div class="row">
                                            @foreach ($items->media_soal as $media)
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
                                </div>


                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    <label>Jawab:</label>
                                    <div>{{ $items->opsi }}</div>

                                

                                        <label for="skorInput">Skor:</label>
                                        <input type="number" id="skorInput" min="0"
                                            max="{{ $items->skor_per_soal }}" name="skor" class="form-control"
                                            value="{{ $items->nilai }}" style="width: 100px;" readonly>

                                </div>

                            </div>
                        </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection


