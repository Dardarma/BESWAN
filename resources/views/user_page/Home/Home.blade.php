@extends('user_page.layout')
@section('style')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .info-card {
            border-radius: 15px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-width: 350px;
            min-height: 300px;
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
            background-color: #AADDFF;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Horizontal Scroll Container */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 20px;
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        .horizontal-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .horizontal-scroll::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb {
            background: rgba(136, 136, 136, 0.05);
            border-radius: 10px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(85, 85, 85, 0.2);
        }

        /* Scroll buttons */
        .scroll-container {
            position: relative;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .scroll-btn:hover {
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .scroll-btn.left {
            left: 10px;
            jus
        }

        .scroll-btn.right {
            right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5 text-center">
        <div class="container">
            <div class="scroll-container">
                <!-- Scroll buttons -->
                <button class="scroll-btn left" onclick="scrollLeftCards()">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                    </svg>
                </button>
                <button class="scroll-btn right" onclick="scrollRightCards()">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </button>

                <!-- Horizontal scrollable cards -->
                <div class="horizontal-scroll" id="cardContainer">
                    @foreach ($level as $item)
                        <div class="info-card"
                            style="background-color: {{ $item->id_level_murid ? '#AADDFF' : 'rgba(170, 221, 255, 0.3)' }};">
                            @if ($item->id_level_murid)
                                <div class="row w-100 mb-3">
                                    <div class="col-3">
                                        <img src="{{ asset('icon\Biru\Level Biru.svg') }}" class="img-fluid"
                                            style="width: 50x; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h3>Level</h3>
                                        <h2> {{ $item->nama_level }} <h2>
                                    </div>
                                </div>
                                <div class="mx-3 w-100">
                                    <div class="d-flex flex-column align-items-start">
                                        <p class="pb-0 mb-0" style="font-size: 30px">Progres</p>
                                        <h1 class="pb-0 mb-0" style="font-size: 50px"> {{ $item->exp_progress }} %</h1>
                                    </div>

                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex justify-content-between align-items-center mr-3 mb-1">
                                                <p class="small mb-0">Last Update</p>
                                                <p class="small mb-0"> {{ $item->exp }} /
                                                    {{ $item->jumlah_quiz_posttest }} </p>
                                            </div>
                                            <div class="progress mr-3"
                                                style="border-radius: 10px; background-color: #283A64;">
                                                <div class="progress-bar progress-bar-striped" role="progressbar"
                                                    aria-valuenow="{{ $item->exp_progress }}" aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    style="width: {{ $item->exp_progress }}%; background-color: #38BDF8; border-radius: 10px;">
                                                </div>
                                            </div>
                                        </div>
                                        @if ($item->exp_progress >= 70)
                                            <a href="{{url('/user/pretest/'. $item->next_level_pretest_quiz_id)}}" class="btn"
                                                style="background-color: #17A2B8; color:white; border-radius:10px">Pre Test
                                                {{ $item->urutan_level + 1 }} </a>
                                        @else
                                            <button disabled class="btn"
                                                style="background-color: #a0a0a0; color:white; border-radius:10px; cursor: not-allowed;">Pre
                                                Test</button>
                                        @endif

                                    </div>

                                </div>
                            @else
                                <div class="d-flex flex-column justify-content-center align-items-center h-100 w-100 "
                                    style="color:#283A64">
                                    <img src="{{ asset('icon\Biru\Level Biru.svg') }}" class="img-fluid mb-3"
                                        style="width: 70px; height: 70px; object-fit: ">
                                    <h3>{{ $item->nama_level }}</h3>
                                    <div class="mt-2 mb-4">
                                        <i class="fas fa-lock" style="font-size: 24px;"></i>
                                    </div>
                                    <p class="text-center" style="font-size: 18px; ">Complete the previous level to unlock
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 mb-4 d-flex justify-content-center">
                    <div class="info-card" style="width: 95%; min-height: 400px;">
                        <div class="w-100">
                            <div class="d-flex flex-column align-items-start">
                                <h1 class="mb-4">Daily Activity</h5>
                            </div>
                            <div class="mt-3" style="width: 100%; height: 250px; position: relative;">
                                <iframe src="{{ route('chart') }}" width="100%" height="250"
                                    style="border:0;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('script')

    <script>
        function scrollLeftCards() {
            const container = document.getElementById('cardContainer');
            container.scrollBy({
                left: -300, // Adjust the value to control the scroll distance
                behavior: 'smooth'
            });
        }

        function scrollRightCards() {
            const container = document.getElementById('cardContainer');
            container.scrollBy({
                left: 300, // Adjust the value to control the scroll distance
                behavior: 'smooth'
            });
        }

        // Modern Chart.js implementation
       
    </script>
