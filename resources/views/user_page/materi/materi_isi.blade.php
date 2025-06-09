@extends('user_page.layout')

@section('style')
    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 1rem 1.25rem;
        }

        .btn-back {
            min-width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .materi-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="{{ url('/user/materi') }}" class="btn btn-secondary btn-back mx-2">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                            <div class="materi-info">
                                <h3 class="materi-title">{{ $materi->judul }}</h3>
                                <span>{{ $materi->nama_level }}</span>
                            </div>
                        </div>
                        <a href="{{url('/user/materi/comment/'.$materi->id)}}" class="" >
                            <img src="{{asset('icon/Biru/Forum Ijo.svg')}}" class="mx-3" style="height: 30px; width:auto;" alt="">
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mt-2 px-2">
                        {!! $materi->konten !!}
                    </div>
                    <div class="mt-2 px-2">
                        @if (!empty($materi->url_video))
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="ratio" style="height: 50vh;">
                                        <iframe src="{{ $materi->url_video }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen style="width: 100%; height: 100%;">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
