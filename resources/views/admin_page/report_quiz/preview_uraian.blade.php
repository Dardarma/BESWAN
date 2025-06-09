@extends('admin_page.layout')
@section('content')
    <div class="row mx-2 d-flex justify-content-center">


        <div class="col-10 my-3">
            <div class="card shadow" style=" background-color: #f0f4ff8b;">
                <div class="card-header align-items-center row">
                    <div class="d-flex align-items-center col-6">
                        <a href="{{ url('admin/quiz_report/list/' . $id_quiz->quiz_id) }}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Uraian</h5>

                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <button class="btn btn-primary mx-2" style="border-radius: 5px;" onclick="updateSkor(this)">
                            Submit nilai
                        </button>
                        @if(in_array($tipe_tersedia, ['isian_singkat']))
                        <a href="{{ url('admin/quiz_report/isian_singkat/' . $id) }}" class="btn btn-primary mx-2"
                            style="border-radius: 5px;">
                            Isian Singkat
                        </a>
                        @endif
                        @if(in_array($tipe_tersedia, ['pilihan_ganda']))
                        <a href="{{ url('admin/quiz_report/pilihan_ganda/' . $id) }}" class="btn btn-primary"
                            style="border-radius: 5px;">
                            Pilihan Ganda
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">
                    @foreach ($soal as $items)
                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">

                                <div class=" mb-3">
                                    <div class="w-100 d-flex align-items-start mb-3">
                                        <div class="me-3 fw-bold fs-4">{{ $items->urutan_soal }}.</div>
                                        <div class="flex-grow-1">{!! $items->soal !!}</div>
                                    </div>
                                    @if ($items->media_soal && $items->media_soal->count() > 0)
                                        <div class="row">
                                            @foreach ($items->media_soal as $media)
                                                @if ($media->type_media == 'image')
                                                    <div class="col-4 mb-2 mx-1 d-flex justify-content-center align-items-center"
                                                        style="overflow: hidden;">
                                                        <img src="{{ asset('storage/' . $media->media) }}"
                                                            class="img-fluid rounded" alt="Media Soal"
                                                            style="max-width: 100%; max-height: 150px;">
                                                    </div>
                                                @elseif($media->type_media == 'audio')
                                                    <div
                                                        class="col-4 mb-2 mx-1 d-flex justify-content-center align-items-center">
                                                        <audio controls style="max-width: 100%; max-height: 50px;">
                                                            <source src="{{ asset('storage/' . $media->media) }}"
                                                                type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </div>
                                                @elseif($media->type_media == 'video')
                                                    <div class="col-4 mb-2 mx-1 d-flex justify-content-center align-items-center"
                                                        style="overflow: hidden;">
                                                        <video controls class="img-fluid rounded"
                                                            style="max-width: 100%; max-height: 150px;">
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


                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    <label>Jawab:</label>
                                    <div>{{ $items->jawaban }}</div>                                    <label for="skorInput">Skor:</label>
                                    <input type="number" id="skorInput_{{ $items->soal_terpilih_id }}" min="0"
                                        max="{{ $items->skor_per_soal ?? 100 }}" name="skor" class="form-control skor-input"
                                        value="{{ $items->nilai }}" style="width: 100px;"
                                        data-soal-id="{{ $items->soal_terpilih_id }}" 
                                        oninput="validateScore(this, {{ $items->skor_per_soal ?? 100 }})">
                                    <small class="text-muted">Nilai maksimum: {{ $items->skor_per_soal ?? 100 }}</small>
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
        // Fungsi untuk memvalidasi skor agar tidak melebihi nilai maksimum
        function validateScore(input, maxScore) {
            if (input.value > maxScore) {
                input.value = maxScore;
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Nilai maksimum yang diperbolehkan adalah ' + maxScore,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else if (input.value < 0) {
                input.value = 0;
            }
        }

        function updateSkor(button) {
            const inputs = document.querySelectorAll('.skor-input');
            const data = [];

            console.log('Found ' + inputs.length + ' score inputs');

            inputs.forEach((input, index) => {
                const soal_terpilih_id = input.getAttribute('data-soal-id');
                const skor = input.value;

                console.log('Input #' + (index + 1) + ':', {
                    element: input,
                    id: soal_terpilih_id,
                    skor: skor
                });

                if (soal_terpilih_id && skor !== "") {
                    data.push({
                        soal_terpilih_id: soal_terpilih_id,
                        skor: parseFloat(skor)
                    });
                }
            });

            if (data.length === 0) {
                alert("Tidak ada data nilai yang valid untuk disimpan");
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Menyimpan nilai...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Using XMLHttpRequest for more control
            const xhr = new XMLHttpRequest();
            xhr.open('PUT', "{{ url('admin/quiz_report/update_skor') }}", true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        // Log debug info to console
                        if (response.debug_info) {
                            console.log('Debug Info:', response.debug_info);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Nilai berhasil disimpan!'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal menyimpan nilai'
                        });
                    }
                } else {
                    console.error(xhr.statusText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error ' + xhr.status,
                        text: 'Terjadi kesalahan saat menyimpan nilai: ' + xhr.statusText
                    });
                }
            };

            xhr.onerror = function() {
                console.error('Network Error');
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Terjadi kesalahan jaringan saat menyimpan nilai.'
                });
            };

            xhr.send(JSON.stringify({
                items: data
            }));
        }
    </script>
@endsection
