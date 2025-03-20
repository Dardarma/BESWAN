@extends('user_page.layout')
@section('content')


<div class="container mt-5 text-center">
    <h1>Choose your level</h1>

    <div class="row">
        @php
            $colors = ['#3EBDC4', '#2895C0', '#005FC3'];
        @endphp

        @foreach ($level as $index => $level)
            <div class="col-12 d-flex justify-content-center mt-5">
                <a href="" type="button" class="btn btn-block col-9" 
                    style="background-color: {{ $colors[$index % count($colors)] }}; color: #fff;">
                    <h1>Level {{ $level->urutan_level }}</h1>
                    <h2>{{ $level->nama_level }}</h2>
                </a>
            </div>
        @endforeach
    </div>
</div>

@endsection