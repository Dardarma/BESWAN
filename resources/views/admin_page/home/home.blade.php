@extends('admin_page.layout')
<style>
    .info-card {
        border-radius: 5px;
        color: #283A64;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-width: 300px;
        min-height: 150px;
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        padding: 10px;
        background-color: #AADDFF;
    }
</style>
@section('style')
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                {{-- total user --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Total User</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row justify-content-start">
                            @foreach ($level as $item)
                                <div class="info-card col-3 mx-2 my-2">
                                    <div class="row w-100 mb-3">
                                        <div class="col-3 d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('icon\Biru\Level Biru.svg') }}" class="img-fluid mb-0"
                                                style="width: 50x; height: 50px; object-fit: cover;">
                                        </div>
                                        <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                            <h3 class="mb-0">Level</h3>
                                            <h2 class="mb-0"> {{ $item->nama_level }} <h2>
                                        </div>
                                        <div
                                            class="col-12  d-flex flex-column justify-content-start align-items-start px-3">
                                            <h4 class="text-center mb-0">Total User</h4>
                                            <h1 class="text-center mb-0"> {{ $item->jumlah_user }} </h1>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
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
                                    <div class="col-3">
                                        <img src="{{ asset('icon\Biru\Materi Biru.svg') }}" class="img-fluid mb-0"
                                            style="width: 50x; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h3 class="mb-0">Materi</h3>
                                    </div>
                                    <div class="col-12  d-flex flex-column justify-content-start align-items-start px-3">
                                        <h4 class="text-center mb-0">Total Materi</h4>
                                        <h1 class="text-center mb-0"> {{ $materi }} </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card col-3 mx-2 my-2">
                                <div class="row w-100 mb-3">
                                    <div class="col-3">
                                        <img src="{{ asset('icon\Biru\Video Biru.svg') }}" class="img-fluid mb-0"
                                            style="width: 50x; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h3 class="mb-0">Video</h3>
                                    </div>
                                    <div class="col-12  d-flex flex-column justify-content-start align-items-start px-3">
                                        <h4 class="text-center mb-0">Total Video</h4>
                                        <h1 class="text-center mb-0"> {{ $video }} </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card col-3 mx-2 my-2">
                                <div class="row w-100 mb-3">
                                    <div class="col-3">
                                        <img src="{{ asset('icon\Biru\E Book Biru.svg') }}" class="img-fluid mb-0"
                                            style="width: 50x; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="col-9 d-flex flex-column justify-content-start align-items-start">
                                        <h3 class="mb-0">E-Book</h3>
                                    </div>
                                    <div class="col-12  d-flex flex-column justify-content-start align-items-start px-3">
                                        <h4 class="text-center mb-0">Total E-Book</h4>
                                        <h1 class="text-center mb-0"> {{ $e_book }} </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                {{-- grafik user --}}
                <div class="card" >
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
