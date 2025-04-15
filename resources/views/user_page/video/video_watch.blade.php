@extends('user_page.layout')
@section('content')

<div class="container my-4 display-flex ">
    <div class="row ">
        <div >
            <div class="mx-3 mb-3">
                <h1 class="px-2"> {{$video->judul_materi}} </h1>
                <h3 class="px-2"> {{$video->nama_level}} </h3>
                <small class="px-2"> {{$video->deskripsi}} </small>
            </div>             
        </div>   
        <div class="col-md-12">
            <div class="mt-2 px-2">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="ratio" style="height: 50vh;">
                            <iframe 
                                src="{{ $video->url_video }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                style="width: 100%; height: 100%;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection