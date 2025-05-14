@extends('user_page.layout')
@section('style')
<style>
    .custom-card {
        color: white;
        border-radius: 10px;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 80%;
    }
    .icon {
        font-size: 30px;
    }

    .icon-container {
        flex: 2; /* Rasio 2 */
        display: flex;
        justify-content: center;
    }
    .text-content {
        flex: 5; /* Rasio 3 */
        text-align: left;
    }
    .download-icon {
        font-size: 20px;
        color: white;
    }

</style>
@endsection

@section('content')


<div class="container mt-5 text-center">
    <h1>Pilih materi</h1>

    <div class="row">
 
        <div class="container my-5">
            <div class="row">
                @foreach ($materi as $index => $item)
                <div class="col-6 d-flex justify-content-center m-3">
                    <div class="custom-card d-flex mx-2 w-100" style="cursor: pointer; background-color:{{$item->warna}} " onclick="window.location.href='{{ url('user/materi/'.$item->id) }}'">
                        <div class="icon-container">
                            <i class="fa-solid fa-book-open icon"></i>
                        </div>
                        <div class="text-content w-100">
                            <h3 class="mb-1"> {{$item->judul}} </h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0" style="font-size: 15px"> {{$item->deskripsi}} </p>
                                <a href="" 
                                   class="download-icon mr-3 p-2" 
                                   onclick="event.stopPropagation();">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </a>
                            </div>                            
                        </div>
                    </div>
                </div>                
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
//     document.querySelectorAll('.badge').forEach(function(badge) {
//     const bgColor = badge.getAttribute('data-color');
//     badge.style.color = getContrastColor(bgColor);
// });
</script>
@endsection
