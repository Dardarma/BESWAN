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
    <h1>Pilih Video</h1>

    <div class="row">
 
        <div class="container my-5">
            <div class="row mx-auto">
                @foreach ($video as $index => $item)
                <div class="col-3 d-flex justify-content-center">
                    <a href="{{ url('/user/video/'.$item->id)}}" class="card" style="width: 18rem; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <img class="card-img-top" src="https://img.youtube.com/vi/{{ Str::before(Str::afterLast($item->url_video, '/'), '?') }}/hqdefault.jpg" alt="Card image" style="height: 180px; object-fit: cover; ">
                        <div class="card-body text-white" style="background-color: {{$item->warna}};padding: 1rem;">
                            <div class="row align-items-center">
                              <div class="col-2 text-center">
                                <i class="fas fa-video" style="font-size: 1.5rem;"></i>
                              </div>
                              <div class="col-10">
                                <h5 class="" style="">Advance Writing</h5>
                                <h6 class="mb-0">21 March by Name</h6>
                              </div>                              
                            </div>
                          </div>                          
                      </a>
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
