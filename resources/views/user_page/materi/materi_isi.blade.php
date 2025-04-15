@extends('user_page.layout')
@section('content')

<div class="container my-4 display-flex ">
    <div class="row justify-content-center ">
        <div class="col-auto">
            <a href="{{ url('/user/materi') }}" class="me-3 text-dark text-decoration-none">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0"> {{$materi->judul}} </h1>
                    <small class="px-2"> {{$materi->nama_level}} </small>
                </div>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModule">
                   QUIZ
                </button>               
            </div>            
            <div class="mt-4 px-2">
                {!! $materi->deskripsi !!}
            </div>

            <div class="mt-2 px-2">
                @if (!empty($materi->url_video))
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="ratio" style="height: 50vh;">
                            <iframe 
                                src="{{ $materi->url_video }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                style="width: 100%; height: 100%;">
                            </iframe>
                        </div>
                    </div>
                </div>
                @endif
            </div>            
        </div>
    </div>
</div>
@endsection