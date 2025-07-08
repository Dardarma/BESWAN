<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/Logo.png') }}" type="image/png">
    <title>Beswan E-learning</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    
    <!-- Masonry CSS -->
    <link rel="stylesheet" href="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.css">

    @yield('style')

    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            scroll-behavior: smooth;
        }

        html {
            scroll-behavior: smooth;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            z-index: -1;
        }

        .activity-card {
            background-color: #A1E3F9;
            border-radius: 10px;
            padding: 10px;
            text-align: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 150px;
            width: 150px;
            justify-content: start;
            display: flex;
            flex-direction: column;
            color: #0d3f77
        }

        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .activity-icon {
            background-color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .activity-icon i {
            font-size: 24px;
            color: #2b95c3;
        }

        /* Gallery Styles */
        .gallery-container {
            scroll-behavior: smooth;
            cursor: grab;
            max-height: 500px;
        }

        .gallery-masonry {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .gallery-item {
            width: 300px;
            margin-bottom: 15px;
            break-inside: avoid;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .gallery-item img:hover {
            transform: scale(1.05);
        }

        h1.display-4 {
            font-size: 2.5rem;
        }

        h3,
        h4,
        h5 {
            font-size: 90%;
        }

        p,
        li {
            font-size: 16px !important;
        }
    </style>

</head>

<body style="padding-top:0px ;layout-fixed">
    <nav class="navbar d-flex align-items-center justify-content-between navbar-expand-md"
        style="background-color: #005FC3; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 1200px; z-index: 100; border-radius:50px">
        <!-- Logo on left (same for mobile and desktop) -->
        <a class="navbar-brand ml-4 d-flex align-items-center" href="#">
            <img src="{{ asset('image/Logo.png') }}" style="height: 5vh; width: auto;" alt=""
                class="img-fluid">
            <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation"
                style="border: none; padding: 5px;">
                <i class="fas fa-bars" style="color: white; font-size: 1.2rem;"></i>
            </button>
        </a>

        <!-- Mobile menu (collapses) -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home" style="color: white">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#galery" style="color: white">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about" style="color: white">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#location" style="color: white">Information</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center justify-content-end">
            <a href="{{ url('/login') }}" class="btn btn-light btn-sm"
                style="color:#17A2B8; border-radius:50px; margin-right: 10px;">Login</a>
        </div>

    </nav>

    <section id="home">
        <div class="jumbotron jumbotron-fluid background-image d-flex align-items-center"
            style="background-image: 
                url('{{ asset('image/Landing Page Foto Biru.jpg') }}');
                background-size: cover; background-position: center; height: 100vh; background-attachment: fixed; padding: 2rem 1rem;">
            <div class="container" style="color: white;">
                <h3 class="mb-0 p-0">Beswan English Course</h3>
                <h1 class="display-4 p-0 m-0"><b>THE BESWAN</b></h1>
                <h5 class="lead p-0 m-0">IS THE MOST USUALLY</h5>
                <p class="p-0 m-0">Need help? <a href="" style="color: #fff"><u>Contact Here</u></a> </p>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Self Improvement</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-praying-hands"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Pray Activity</h5>
                            <p class="small mb-0">with all member</p>
                        </div>

                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Learn Activity</h5>
                            <p class="small mb-0">with all member</p>
                        </div>

                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Time Management</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- galeri --}}
    <section id="galery">
        <div class="my-5" style="margin-left: 30px; margin-right: 30px;" style="max-height: 450px">
            <!-- Gallery Container -->
            <div id="galleryContainer" class="gallery-container"
                style="overflow-x: auto; white-space: nowrap; padding: 20px 0; scroll-behavior: smooth;">
                <div id="galleryMasonry" class="gallery-masonry" data-masonry='{"itemSelector": ".gallery-item", "gutter": 15, "fitWidth": true}'>
                    <!-- Gallery items will be organized by Masonry -->
                    @foreach ($post as $item)
                        <div class="gallery-item">
                            <a class="items-galery" data-toggle="modal" data-target="#galleryModal"
                                data-judul="{{ $item->judul_activity }}"
                                data-deskripsi="{{ $item->deskripsi_activity }}">
                                <img src="{{ Storage::url($item->file_media) }}" alt="Gallery Image">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Scroll indicator -->
            <div class="text-center mt-3">
                <small class="text-muted">← Scroll horizontally to see more →</small>
            </div>
        </div>
    </section>
    {{-- galeri end --}}


    <section id="about">
        <div class="container my-5 mx-auto">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img src="{{ url(asset('image/Besawn Art 1.png')) }}" style="width: 90%; height:auto">
                </div>
                <div class="col-12 col-md-6">
                    <h4 style="font-size: 32px">PLATFORM FOR E LEARNING</h4>
                    <p style="font-size: 24px">
                        Sistem pembelajaran yang didasarkan pada pengajaran formal dengan bantuan sumber daya elektronik
                        dikenal sebagai E-learning. Meskipun pengajaran dapat dilakukan di dalam atau di luar kelas,
                        penggunaan komputer dan internet merupakan komponen utamanya.
                    </p>
                    <h4 style="font-size: 32px">VISI</h4>
                    <p style="font-size: 24px">
                        Menjadi mitra terdepan dalam pengembangan potensi Sumber Daya Manusia, serta peningkatan
                        kualitas hidup dan kehidupan spiritual umat.
                    </p>
                    <h4 style="font-size: 32px">MISI</h4>
                    <p>
                    <ol type="1">
                        <li style="font-size: 24px">Berperan aktif dalam membangun kehidupan masyarakat yang lebih
                            berkualitas dalam membentuk Tata
                            Pikir, Tata Laku dan Tata Nilai.</li>
                        <li style="font-size: 24px">Berusaha memberikan yang terbaik dalam bermitra dengan masyarakat.
                        </li>
                    </ol>

                    </p>

                </div>
                <div class="col-12 col-md-6">
                    <h4 style="font-size: 32px">PROFIL BESWAN</h4>
                    <p style="font-size: 24px">
                        BESWAN adalah sebuah inisiatif atau unit usaha yang muncul dari kesadaran akan pentingnya
                        nilai-nilai ruhaniah, kepemimpinan yang berintegritas, dan potensi besar yang dimiliki
                        lingkungan
                        seperti Pare, Kediri terutama dalam hal pendidikan alternatif bahasa asing.
                    </p>
                    <h4 style="font-size: 32px">SEJARAH SINGKAT</h4>
                    <p style="font-size: 24px">
                        Berbicara masalah pendidikan alternatif bahasa Inggris dan asing, semacam lembaga kursus, maka
                        Kediri dengan kota Pare-nya akan muncul pertama kali. Hal ini bisa dilihat dengan banyaknya
                        lembaga
                        kursus yang secara kuantitas kurang lebih 40 lembaga. Dengan durasi belajarnya juga bervariasi,
                        antara dua minggu sampal enam bulan. Bahkan ada lembaga yang menyediakan progam studi selama dua
                        tahun, atau setara D2. Melihat data yang ada, siswa berasal dari berbagai daerah di seluruh
                        Indonesia, dan dari segi pendidikan mulai dari tingkat SMP sampai perguruan tinggi. Sehingga
                        kalau
                        dilihat, dinamika yang ada dari daerah ini lumayan tinggi. Adapun potensi yang lain adalah
                        mayoritas
                        pelajar dari siswa kursus dan masyarakat setempat adalah Muslim...
                    </p>

                </div>
                <div class="col-12 col-md-6">
                    <img src="{{ url(asset('image/Besawn Art 2.png')) }}" style="width: 90%; height:auto">
                </div>
            </div>
        </div>
    </section>

    <section id="location">
        <div class="container my-5 mx-auto">
            <div class="row">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1838839130382!2d112.21135306990374!3d-7.770316259921385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785d4d94f729c9%3A0x2920533df14340e8!2sBeswan%20English%20Camp%20%26%20Course!5e0!3m2!1sid!2sid!4v1748093500688!5m2!1sid!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy" class="w-100" height="450"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <footer class="bg-light text-lg-start mt-5" style="background-color: #578FCA; color: white;">
        <div class="p-4" style="background-color: #005FC3; color: white;">
            <div class="row">
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <img src="{{ url(asset('image/Logo.png')) }}" alt=""
                        style="height: 8vh; width: auto; max-height: 60px;" class="img-fluid">
                    <p class="my-3">
                        Jl. Mojo No 105, Tertek, Kec. Pare,<br>
                        Kabupaten Kediri, Jawa Timur 64215
                    </p>
                </div>
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="d-flex flex-column">
                        <a href="https://www.instagram.com/kampunginggris.beswan"
                            class="text-white d-flex align-items-center">
                            <img src="{{ url(asset('icon/Putih/Instagram Putih.svg')) }}" alt=""
                                style="width: 30px; height: 30px;" class="mr-2">
                            <img src="{{ url(asset('icon/Putih/facebook.png')) }}" alt=""
                                style="width: 30px; height: 30px;" class="mr-2">
                        </a>
                        @kampunginggris.beswan
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex flex-column">
                        <a href="https://www.instagram.com/kampunginggris.beswan"
                            class="text-white d-flex align-items-center">
                            <img src="{{ url(asset('icon/Putih/Whatsapp White.svg')) }}" alt=""
                                style="width: 30px; height: 30px;" class="mr-2">
                        </a>
                        081217130420 <br>
                        081217130420
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('user_page.landing_page.modal_gallery')

</body>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>

<!-- Masonry JS -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<!-- imagesLoaded for better image loading handling -->
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Gallery Organization and Navigation Script -->
<script>
    $(document).ready(function() {
        // Initialize Masonry after images are loaded
        const $galleryMasonry = $('#galleryMasonry');
        
        // Wait for all images to load
        $galleryMasonry.imagesLoaded(function() {
            // Initialize Masonry
            $galleryMasonry.masonry({
                itemSelector: '.gallery-item',
                gutter: 15,
                fitWidth: true,
                transitionDuration: '0.3s'
            });
        });

        // Gallery modal handler
        $('.items-galery').on('click', function() {
            const judul = $(this).data('judul');
            const deskripsi = $(this).data('deskripsi');

            // Set isi elemen heading dan paragraf dalam modal
            $('#modal .modal-title.judul').text(judul);
            $('#modal .deskripsi').text(deskripsi);

            // Tampilkan modal
            $('#modal').modal('show');
        });

        // Relayout masonry on window resize
        $(window).resize(function() {
            $galleryMasonry.masonry('layout');
        });
    });
</script>

</body>

</html>
