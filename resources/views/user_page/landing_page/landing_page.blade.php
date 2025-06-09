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
            -webkit-overflow-scrolling: touch;
            /* Enable smooth touch scrolling on iOS */
        }

        .gallery-container:active {
            cursor: grabbing;
        }

        .gallery-container::-webkit-scrollbar {
            height: 8px;
        }

        .gallery-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .gallery-container::-webkit-scrollbar-thumb {
            background: #005FC3;
            border-radius: 10px;
        }

        .gallery-container::-webkit-scrollbar-thumb:hover {
            background: #004494;
        }

        .gallery-item {
            border-radius: 8px !important;
            /* Sharp corners - smaller radius */
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .gallery-item img {
            transition: transform 0.3s ease;
            /* Pinterest style with max dimensions but maintain aspect ratio */
            max-width: 350px;
            width: 100%;
            height: auto;
            /* Let height adjust naturally to maintain aspect ratio */
            object-fit: contain;
            /* Don't crop, show full image */
            display: block;
        }

        .gallery-column {
            display: flex;
            flex-direction: column;
            gap: 15px;
            min-width: 350px;
            max-width: 350px;
            flex-shrink: 0;
        }

        .gallery-masonry {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        /* Single column layout for portrait images */
        .gallery-masonry.single-column {
            justify-content: center;
        }

        .gallery-masonry.single-column .gallery-column {
            min-width: 400px;
            max-width: 400px;
        }

        .gallery-masonry.single-column .gallery-item img {
            max-width: 400px;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* Navigation buttons */
        .gallery-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(0, 95, 195, 0.8);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .gallery-nav-btn:hover {
            background: rgba(0, 95, 195, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .gallery-nav-btn:disabled {
            background: rgba(0, 0, 0, 0.3);
            cursor: not-allowed;
            transform: translateY(-50%) scale(1);
        }

        .gallery-nav-left {
            left: 10px;
        }

        .gallery-nav-right {
            right: 10px;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 767.98px) {
            .navbar {
                padding: 5px 15px;
            }

            .navbar-collapse {
                background-color: #005FC3;
                border-radius: 20px;
                margin-top: 10px;
                padding: 10px;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 10;
            }

            .activity-card {
                height: 120px;
                width: 120px;
            }

            .activity-icon {
                width: 40px;
                height: 40px;
            }

            .activity-icon i {
                font-size: 18px;
            }

            .gallery-nav-btn {
                width: 30px;
                height: 30px;
            }

            .gallery-column {
                min-width: 250px;
                max-width: 250px;
            }

            .gallery-item img {
                max-width: 250px;
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
            <!-- Gallery with Navigation -->
            <div style="position: relative;">
                <!-- Navigation Buttons -->
                <button id="scrollLeft" class="gallery-nav-btn gallery-nav-left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="scrollRight" class="gallery-nav-btn gallery-nav-right">
                    <i class="fas fa-chevron-right"></i>
                </button>
    
                <!-- Gallery Container -->
                <div id="galleryContainer" class="gallery-container"
                    style="overflow-x: auto; white-space: nowrap; padding: 20px 0; scroll-behavior: smooth;">
                    <div id="galleryMasonry" class="gallery-masonry">
                        <!-- Dynamic columns will be generated by JavaScript -->
                        @foreach ($post as $item)
                            <div class="gallery-item" data-src="{{ Storage::url($item->file_media) }}" style="display: none;">
                                <a class="items-galery" data-toggle="modal" data-target="#galleryModal"
                                    data-judul="{{ $item->judul_activity }}"
                                    data-deskripsi="{{ $item->deskripsi_activity }}">
                                    <img src="{{ Storage::url($item->file_media) }}" alt="Gallery Image">
                                </a>
                            </div>
                        @endforeach
                    </div>
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
                        <li style="font-size: 24px">Berusaha memberikan yang terbaik dalam bermitra dengan masyarakat.</li>
                    </ol>
    
                    </p>
    
                </div>
                <div class="col-12 col-md-6">
                    <h4 style="font-size: 32px">PROFIL BESWAN</h4>
                    <p style="font-size: 24px">
                        BESWAN adalah sebuah inisiatif atau unit usaha yang muncul dari kesadaran akan pentingnya
                        nilai-nilai ruhaniah, kepemimpinan yang berintegritas, dan potensi besar yang dimiliki lingkungan
                        seperti Pare, Kediri terutama dalam hal pendidikan alternatif bahasa asing.
                    </p>
                    <h4 style="font-size: 32px">SEJARAH SINGKAT</h4>
                    <p style="font-size: 24px">
                        Berbicara masalah pendidikan alternatif bahasa Inggris dan asing, semacam lembaga kursus, maka
                        Kediri dengan kota Pare-nya akan muncul pertama kali. Hal ini bisa dilihat dengan banyaknya lembaga
                        kursus yang secara kuantitas kurang lebih 40 lembaga. Dengan durasi belajarnya juga bervariasi,
                        antara dua minggu sampal enam bulan. Bahkan ada lembaga yang menyediakan progam studi selama dua
                        tahun, atau setara D2. Melihat data yang ada, siswa berasal dari berbagai daerah di seluruh
                        Indonesia, dan dari segi pendidikan mulai dari tingkat SMP sampai perguruan tinggi. Sehingga kalau
                        dilihat, dinamika yang ada dari daerah ini lumayan tinggi. Adapun potensi yang lain adalah mayoritas
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


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Gallery Organization and Navigation Script -->
<script>
    // Function to organize gallery based on image heights
    function organizeGallery() {
        console.log('organizeGallery function called');
        const galleryMasonry = document.getElementById('galleryMasonry');
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        console.log('Found', galleryItems.length, 'gallery items');
        
        // Clear existing columns
        galleryMasonry.innerHTML = '';
        
        // Group images by height categories
        const tallImages = []; // > 500px height
        const mediumImages = []; // 400-500px height
        const shortImages = []; // < 400px height
        
        let loadedImages = 0;
        const totalImages = galleryItems.length;
        
        if (totalImages === 0) {
            console.log('No gallery items found');
            return;
        }
        
        // Function to check if all images are loaded and organize
        function checkAndOrganize() {
            loadedImages++;
            console.log('Images loaded:', loadedImages, '/', totalImages);
            if (loadedImages === totalImages) {
                console.log('All images loaded, creating columns...');
                createColumns(tallImages, mediumImages, shortImages);
            }
        }
        
        // Categorize images based on their natural height
        galleryItems.forEach((item, index) => {
            const img = item.querySelector('img');
            
            // Handle images that are already loaded
            if (img.complete && img.naturalHeight > 0) {
                categorizeImage(img, item, tallImages, mediumImages, shortImages);
                checkAndOrganize();
            } else {
                // Handle images that are still loading
                img.onload = function() {
                    categorizeImage(this, item, tallImages, mediumImages, shortImages);
                    checkAndOrganize();
                };
                
                // Handle images that fail to load
                img.onerror = function() {
                    console.log('Image failed to load:', this.src);
                    // Default to short images category for failed loads
                    shortImages.push(item);
                    checkAndOrganize();
                };
            }
        });
    }
    
    function categorizeImage(img, item, tallImages, mediumImages, shortImages) {
        const naturalHeight = img.naturalHeight;
        console.log('Image height:', naturalHeight);
        
        if (naturalHeight > 500) {
            console.log('Adding to tall images');
            tallImages.push(item);
        } else if (naturalHeight >= 400) {
            console.log('Adding to medium images');
            mediumImages.push(item);
        } else {
            console.log('Adding to short images');
            shortImages.push(item);
        }
    }
    
    function createColumns(tallImages, mediumImages, shortImages) {
        const galleryMasonry = document.getElementById('galleryMasonry');
        
        console.log('Creating columns - Tall:', tallImages.length, 'Medium:', mediumImages.length, 'Short:', shortImages.length);
        
        // Create columns for tall images (1 image per column)
        tallImages.forEach(item => {
            const column = document.createElement('div');
            column.className = 'gallery-column';
            column.appendChild(item.cloneNode(true));
            galleryMasonry.appendChild(column);
        });
        
        // Create columns for medium images (2 images per column)
        for (let i = 0; i < mediumImages.length; i += 2) {
            const column = document.createElement('div');
            column.className = 'gallery-column';
            
            column.appendChild(mediumImages[i].cloneNode(true));
            if (mediumImages[i + 1]) {
                column.appendChild(mediumImages[i + 1].cloneNode(true));
            }
            
            galleryMasonry.appendChild(column);
        }
        
        // Create columns for short images (3 images per column)
        for (let i = 0; i < shortImages.length; i += 3) {
            const column = document.createElement('div');
            column.className = 'gallery-column';
            
            column.appendChild(shortImages[i].cloneNode(true));
            if (shortImages[i + 1]) {
                column.appendChild(shortImages[i + 1].cloneNode(true));
            }
            if (shortImages[i + 2]) {
                column.appendChild(shortImages[i + 2].cloneNode(true));
            }
            
            galleryMasonry.appendChild(column);
        }
        
        // Show all items
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.style.display = 'block';
        });
        
        console.log('Gallery organization complete');
        
        // Re-initialize gallery navigation after reorganization
        initializeGalleryNavigation();
    }

    $(document).ready(function() {
        // Initialize gallery organization with longer delay to ensure images are loaded
        setTimeout(function() {
            console.log('Initializing gallery organization...');
            organizeGallery();
        }, 500); // Increased delay
        
        // Initialize gallery navigation
        initializeGalleryNavigation();
    });

    function initializeGalleryNavigation() {
        // Smooth scrolling for navigation links
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            
            const target = $(this.getAttribute('href'));
            if(target.length) {
                const scrollTop = target.offset().top - 80; // Offset for fixed navbar
                $('html, body').animate({
                    scrollTop: scrollTop
                }, 800, 'easeInOutQuad');
            }
        });

        
        
        const galleryContainer = $('#galleryContainer');
        let scrollAmount = 370; // Default for desktop: 350px + 20px gap

        // Adjust scroll amount based on screen size
        function updateScrollAmount() {
            if (window.innerWidth <= 767.98) {
                scrollAmount = 270; // For mobile: 250px + 20px gap
            } else {
                scrollAmount = 370; // For desktop: 350px + 20px gap
            }
        }

        // Initial setup
        updateScrollAmount();

        // Update on window resize
        $(window).resize(function() {
            updateScrollAmount();
        });

        // Button navigation
        $('#scrollLeft').click(function() {
            galleryContainer.animate({
                scrollLeft: '-=' + scrollAmount
            }, 300);
        });

        $('#scrollRight').click(function() {
            galleryContainer.animate({
                scrollLeft: '+=' + scrollAmount
            }, 300);
        });

        // Update button states
        function updateNavButtons() {
            const container = galleryContainer[0];
            const scrollLeft = container.scrollLeft;
            const maxScroll = container.scrollWidth - container.clientWidth;

            $('#scrollLeft').prop('disabled', scrollLeft <= 5);
            $('#scrollRight').prop('disabled', scrollLeft >= maxScroll - 5);
        }

        // Listen for scroll events
        galleryContainer.on('scroll', updateNavButtons);

        // Initialize button states
        updateNavButtons();

        // Touch and mouse drag support
        let isDown = false;
        let startX;
        let scrollLeftStart;
        let startTime;
        let endTime;

        const container = galleryContainer[0];

        // Mouse events
        container.addEventListener('mousedown', startDragging);
        container.addEventListener('mouseleave', stopDragging);
        container.addEventListener('mouseup', stopDragging);
        container.addEventListener('mousemove', whileDragging);

        // Touch events for mobile
        container.addEventListener('touchstart', handleTouchStart, {
            passive: false
        });
        container.addEventListener('touchmove', handleTouchMove, {
            passive: false
        });
        container.addEventListener('touchend', handleTouchEnd);

        function startDragging(e) {
            isDown = true;
            startX = e.pageX - container.offsetLeft;
            scrollLeftStart = container.scrollLeft;
            startTime = Date.now();
            container.style.cursor = 'grabbing';
            e.preventDefault();
        }

        function stopDragging() {
            isDown = false;
            container.style.cursor = 'grab';
            endTime = Date.now();

            // Add momentum scrolling
            if (endTime - startTime < 300) {
                const momentum = (scrollLeftStart - container.scrollLeft) * 2;
                if (Math.abs(momentum) > 50) {
                    $(container).animate({
                        scrollLeft: container.scrollLeft + momentum
                    }, 400, 'easeOutQuart');
                }
            }
        }

        function whileDragging(e) {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 1.5;
            container.scrollLeft = scrollLeftStart - walk;
        }

        // Touch handling
        let touchStartX = 0;
        let touchScrollStart = 0;

        function handleTouchStart(e) {
            touchStartX = e.touches[0].clientX;
            touchScrollStart = container.scrollLeft;
            startTime = Date.now();
        }

        function handleTouchMove(e) {
            if (!touchStartX) return;

            const touchX = e.touches[0].clientX;
            const diff = touchStartX - touchX;
            container.scrollLeft = touchScrollStart + diff;

            // Prevent page scrolling when scrolling gallery
            if (Math.abs(diff) > 10) {
                e.preventDefault();
            }
        }

        function handleTouchEnd(e) {
            endTime = Date.now();

            // Add momentum for quick swipes
            if (endTime - startTime < 300) {
                const touchEndX = e.changedTouches[0].clientX;
                const swipeDistance = touchStartX - touchEndX;

                if (Math.abs(swipeDistance) > 50) {
                    const momentum = swipeDistance * 3;
                    $(container).animate({
                        scrollLeft: container.scrollLeft + momentum
                    }, 400, 'easeOutQuart');
                }
            }

            touchStartX = 0;
            touchScrollStart = 0;
        }

        // Keyboard navigation
        $(document).keydown(function(e) {
            if (galleryContainer.is(':hover') || galleryContainer.is(':focus-within')) {
                if (e.keyCode === 37) { // Left arrow
                    e.preventDefault();
                    $('#scrollLeft').click();
                } else if (e.keyCode === 39) { // Right arrow
                    e.preventDefault();
                    $('#scrollRight').click();
                }
            }
        });

        // Add easing function for smoother animations
        $.easing.easeOutQuart = function(x) {
            return 1 - Math.pow(1 - x, 4);
        };
        
        // Add additional easing function for smooth scrolling
        $.easing.easeInOutQuad = function(x) {
            return x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2;
        };

        // Gallery modal handler
        $('.items-galery').off('click').on('click', function() {
            const judul = $(this).data('judul');
            const deskripsi = $(this).data('deskripsi');

            // Set isi elemen heading dan paragraf dalam modal
            $('#modal .modal-title.judul').text(judul);
            $('#modal .deskripsi').text(deskripsi);

            // Tampilkan modal
            $('#modal').modal('show');
        });
    }
</script>

</body>

</html>
