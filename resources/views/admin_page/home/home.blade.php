@extends('admin_page.layout')
<style>
    .info-card {
        border-radius: 5px;
        color: #283A64;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-width: 100%;
        min-height: 8%;
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        padding: 5px;
        background-color: #AADDFF;
    }
</style>
@section('style')
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-8 col-12">
                {{-- total user --}}
                <div class="card" style="min-height: 580px">
                    <div class="card-header d-flex justify-content-between align-items-center" >
                        <h3 class="card-title">Total User</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <iframe src="{{ route('chartUser') }}" width="100%" height="500" style="border:0;"></iframe>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-4 col-12">
                {{-- total materi --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Total Materi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="info-card col-3 mx-2 my-2">
                                <div class="row w-100 mb-3">
                                    <div class="col-2">
                                        <img src="{{ asset('icon\Biru\Materi Biru.svg') }}" class="img-fluid pt-2 pl-2 m-0"
                                            style="width: 30px; height: 30px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h4 class="mb-0">Materi</h4>
                                    </div>
                                    <div class="col-12 d-flex flex-column justify-content-start align-items-start px-3">
                                        <h5 class="text-center mb-0">Total Materi</h5>
                                        <h3 class="text-center mb-0"> {{ $materi }} </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card col-3 mx-2 my-2">
                                <div class="row w-100 mb-3">
                                    <div class="col-2">
                                        <img src="{{ asset('icon\Biru\Video Biru.svg') }}" class="img-fluid pt-2 pl-2 m-0"
                                            style="width: 30px; height: 30px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h4 class="mb-0">Video</h4>
                                    </div>
                                    <div class="col-12 d-flex flex-column justify-content-start align-items-start px-3">
                                        <h5 class="text-center mb-0">Total Video</h5>
                                        <h3 class="text-center mb-0"> {{ $video }} </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card col-3 mx-2 my-2">
                                <div class="row w-100 mb-3">
                                    <div class="col-2">
                                        <img src="{{ asset('icon\Biru\E Book Biru.svg') }}" class="img-fluid pt-2 pl-2 m-0"
                                            style="width: 30px; height: 30px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h4 class="mb-0">E-Book</h4>
                                    </div>
                                    <div class="col-12 d-flex flex-column justify-content-start align-items-start px-3">
                                        <h5 class="text-center mb-0">Total E-Book</h5>
                                        <h3 class="text-center mb-0"> {{ $e_book }} </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="info-card col-3 mx-2 my-2">
                                <div class="row w-100 mb-3">
                                    <div class="col-2">
                                        <img src="{{ asset('icon\Biru\Quiz Biru.svg') }}" class="img-fluid pt-2 pl-2 m-0"
                                            style="width: 30px; height: 30px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h4 class="mb-0">Quiz</h4>
                                    </div>
                                    <div class="col-12 d-flex flex-column justify-content-start align-items-start px-3">
                                        <h5 class="text-center mb-0">Total Quiz</h5>
                                        <h3 class="text-center mb-0"> {{ $quiz }} </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-12 mt-3">
                {{-- grafik user --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h3 class="card-title">Users Per Year</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" class="d-flex align-items-center" action={{ route('chartAdmin') }}>
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <select class="custom-select" name="tahun" id="tahunSelect"
                                        onchange="this.form.submit()">
                                        <!-- opsi akan diisi oleh JavaScript -->
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <iframe src="{{ route('chartAdmin') }}" width="100%" height="300" style="border:0;"></iframe>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        const tahunAwal = 2025;
        const tahunSekarang = new Date().getFullYear();
        const tahunSelect = document.getElementById('tahunSelect');

        for (let tahun = tahunAwal; tahun <= tahunSekarang; tahun++) {
            const option = document.createElement('option');
            option.value = tahun;
            option.textContent = tahun;
            tahunSelect.appendChild(option);
        }

        // Optional: pilih tahun dari parameter URL jika ada
        const urlParams = new URLSearchParams(window.location.search);
        const selectedTahun = urlParams.get('tahun');
        if (selectedTahun) {
            tahunSelect.value = selectedTahun;
        }
    </script>
@endsection
