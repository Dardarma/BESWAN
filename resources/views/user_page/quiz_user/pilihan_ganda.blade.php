@extends('user_page.quiz_user.layout_quiz')
@section('content')
    <div class="row mx-2">


        <div class="col-md-4 col-12 my-3">
            <div class="card mt-1">
                <div class="card-header d-flex  align-items-center">
                    <h3 class="card-title"> {{ $quiz_user->judul }} </h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;text-align: center;">
                        <tr>
                            <td class="p-2" style=" width: 25%;">
                                <strong>Jenis Soal</strong>
                            </td>
                            <td class="p-2" style="width: 25%;">
                                <strong>Waktu</strong>
                            </td>
                            <td class="p-2" style=" width: 25%;">
                                <strong>Jumlah Soal</strong>
                            </td>
                            <td class="p-2" style=" width: 25%;">
                                <strong>Toatal Soal</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Pilihan Ganda</p>
                            </td>
                            <td>
                                <p id="countdown"></p>
                            </td>
                            <td>
                                <p> {{ $jumlah_soal->jumlah_soal }} </p>
                            </td>
                            <td>
                                <p> {{ $quiz_user->jumlah_soal }} </p>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start">
                            <btn type="button" class="btn btn-primary sm btn-kumpulkan"
                                data-id="{{ $quiz_user->quiz_user_id }}" style="border-radius: 5px;">
                                Selesai
                            </btn>
                            <form id="form-kumpulkan-{{ $quiz_user->quiz_user_id }}"
                                action="{{ url('/user/quiz/kumpulkan_jawaban/' . $quiz_user->quiz_user_id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="waktu_selesai" value="{{ $quiz_user->waktu_selesai }}">
                            </form>
                        </div>
                        <div class="d-flex justify-content-end">
                            @if (in_array('isian_singkat', $tipe_tersedia))
                                <a href="{{ url('/user/quiz/kerjakan/isian_singkat/' . $quiz_user->quiz_user_id) }}"
                                    type="button" class="btn btn-primary sm mx-1" style="border-radius: 5px;">
                                    Isian Singkat
                                </a>
                            @endif
                            @if (in_array('uraian', $tipe_tersedia))
                                <a href="{{ url('/user/quiz/kerjakan/isian_singkat/' . $quiz_user->quiz_user_id) }}"
                                    type="button" class="btn btn-primary sm mx-1" style="border-radius: 5px;">
                                    Uraian
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-8 col-12 mb-3 mt-1">
            <div class="card shadow" style="height: 600px; overflow-y: auto;">
                <div class="card-body p-4">
                    @foreach ($grouped as $soal_id => $items)
                        @php
                            $soal = $items[0];
                            $mediaList = $items->whereNotNull('media')->unique('media_soal_id');
                        @endphp
                        <form action="{{ url('user/quiz/simpan_jawaban') }}" method="POST" class="form-soal">
                            @csrf
                            @method('PUT')
                            <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                                <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3 fw-bold fs-4">{{ $soal->urutan_soal }}.</div>
                                        <div class="flex-grow-1">
                                            <div class="mb-3 p-0">
                                                {!! $soal->soal !!}
                                            </div>
                                            @if ($mediaList->count())
                                                <div class="row">
                                                    @foreach ($mediaList as $media)
                                                        @if ($media->type_media == 'image')
                                                            <div class="col-4 mt-2">
                                                                <img src="{{ asset('storage/' . $media->media) }}"
                                                                    class="img-fluid rounded" alt="Media Soal">
                                                            </div>
                                                        @elseif($media->type_media == 'audio')
                                                            <div class="col-12 mb-2">
                                                                <audio controls>
                                                                    <source src="{{ asset('storage/' . $media->media) }}"
                                                                        type="audio/mpeg">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                            </div>
                                                        @elseif($media->type_media == 'video')
                                                            <div class="col-12 mb-2">
                                                                <video controls class="img-fluid rounded">
                                                                    <source src="{{ asset('storage/' . $media->media) }}"
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <input type="hidden" name="soal_terpilih_id"
                                            value="{{ $soal->soal_terpilih_id }}">
                                    </div>

                                    <div class="d-flex flex-column gap-2 opsi-container ">
                                        @foreach ($items as $item)
                                            <div class="form-check d-flex align-items-center my-1">
                                                <input class="form-check-input" type="radio" name="id_opsi_jawaban"
                                                    value="{{ $item->opsi_id }}" id="opsi_{{ $item->opsi_id }}"
                                                    onchange="simpanJawaban(this)"
                                                    {{ $item->opsi_id == $soal->id_opsi_jawaban ? 'checked' : '' }}>

                                                <label class="form-check-label ms-2" for="opsi_{{ $item->opsi_id }}">
                                                    {!! $item->opsi !!}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            // Ambil waktu_selesai dari Laravel (pastikan dalam format ISO)
            let waktuSelesai = new Date("{{ \Carbon\Carbon::parse($quiz_user->waktu_selesai)->toIso8601String() }}");
            let now = new Date();

            // Update countdown tiap detik
            let countdown = setInterval(function() {
                let now = new Date().getTime();
                let distance = waktuSelesai - now;

                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById("countdown").innerHTML = "Waktu Habis";

                    let quizUserId = "{{ $quiz_user->quiz_user_id }}";
                    Swal.fire({
                        title: 'Waktu Habis',
                        text: "Jawaban Anda akan dikumpulkan secara otomatis.",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form-kumpulkan-' + quizUserId).submit();
                        }
                    });

                    return;
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    (hours < 10 ? '0' : '') + hours + ":" +
                    (minutes < 10 ? '0' : '') + minutes + ":" +
                    (seconds < 10 ? '0' : '') + seconds;
            }, 1000);


            // Fungsi untuk menyimpan jawaban
            function simpanJawaban(el) {
                let form = $(el).closest('.form-soal');
                let formData = form.serializeArray();

                // Ambil label jawaban yang dipilih (sebagai field 'jawaban')
                let labelText = $(el).siblings('label').text().trim();

                // Tambahkan ke formData sebagai 'jawaban'
                formData.push({
                    name: 'jawaban',
                    value: labelText
                });

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Jawaban tersimpan:', response);
                        // Tambahkan notifikasi/toast jika perlu
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal menyimpan jawaban:', xhr.responseText);
                    }
                });
            }
            $('.btn-kumpulkan').on('click', function() {
                let quizUserId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan mengumpulkan jawaban!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kumpulkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-kumpulkan-' + quizUserId).submit();
                    }
                });
            });
        </script>
    @endsection
