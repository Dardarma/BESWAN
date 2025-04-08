@extends('user_page.layout')
@section('style')
<style>
    .custom-card {
        background-color: #4A90E2;
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
 
        {{-- @foreach ($level as $index => $level) --}}
        <div class="container my-5">
            <div class="row">
                <div class="col-6 d-flex justify-content-center ">
                    <div class="custom-card d-flex mx-2">
                        <div class="icon-container">
                            <i class="fa-solid fa-book-open icon"></i>
                        </div>                       
                         <div class="text-content">
                            <h3 class="mb-1">Basic Grammar</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0" style="font-size: 10px">Simple Present Tense dan Simple Past Tense mzx zkl nxkl nkxnkl nklxnl nlxkn lnklxn nxl </p>
                                <a href="#" class="download-icon mr-3 p-2"><i class="fa-solid fa-arrow-down"></i></a>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-center ">
                    <div class="custom-card d-flex mx-2">
                        <div class="icon-container">
                            <i class="fa-solid fa-book-open icon"></i>
                        </div>                       
                         <div class="text-content">
                            <h3 class="mb-1">Basic Grammar</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0" style="font-size: 10px">Simple Present Tense dan Simple Past Tense mzx zkl nxkl nkxnkl nklxnl nlxkn lnklxn nxl </p>
                                <a href="#" class="download-icon mr-3 p-2"><i class="fa-solid fa-arrow-down"></i></a>
                            </div>                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @endforeach --}}
    </div>
</div>
@endsection