@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <div class="col-1 m-0 p-0 text-end">
                        <a href="{{ url('/admin/quiz/' . $type_soal->quiz_id) }}" class="btn btn-secondary"><i
                                class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <h3 class="card-title">Informasi Soal</h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;">
                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Judul Quiz</strong>
                                <p>{{ $type_soal->judul_quiz }} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Tipe soal</strong>
                                <p> Pilihan Ganda </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Jumlah Soal</strong>
                                <p>{{ $type_soal->jumlah_soal }}</p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Jumlah Soal Saat ini</strong>
                                <p>{{ $type_soal->jumlah_soal_now }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <form method="POST" action="{{ url('/admin/quiz/soal/create_pilgan') }}" id="form-soal"
                enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center px-3">
                            <div class="flex-grow-1">
                                <h3 class="card-title m-0">Informasi Soal</h3>
                            </div>
                            <div>
                                <input type="hidden" name="quiz_id" value="{{ $type_soal->quiz_id }}">
                                <input type="hidden" name="type_soal" value="{{ $type_soal->id }}">
                                <a href="#" class="btn btn-primary btn-sm ms-3" id="tambah-soal">+ Soal</a>
                                <button type="submit" class="btn btn-success btn-sm ms-3" id="simpan-soal">Simpan</button>
                            </div>
                        </div>
                        <div class="card-body soal-container-wrapper">
                            <!-- Soal awal, jika ada -->
                            @foreach ($soal_quiz as $soal)
                                @php
                                    $opsi_count = count($opsi[$soal->id]);
                                @endphp
                                <div class="card mb-4 shadow-sm soal-container">
                                    <div class="card-body" style="background-color: rgb(224, 239, 244)">
                                        <input type="text" class="form-control mb-2"
                                            name="soal_quiz[{{ $soal->id }}][soal]" value="{{ $soal->soal }}">

                                        <div class="media-forms-container">
                                            @php
                                                $mediaItems = $media_soal[$soal->id] ?? [];
                                                $hasMedia = count($mediaItems) > 0;
                                            @endphp

                                            <div class="text-right mb-3">
                                                <button type="button" class="btn btn-primary btn-sm add-media-btn"
                                                    data-soal-id="{{ $soal->id }}">
                                                    <i class="fas fa-plus"></i> Tambah Media
                                                </button>
                                            </div>

                                            <!-- Display existing media items -->
                                            @if ($hasMedia)
                                                @foreach ($mediaItems as $key_media => $mediaItem)
                                                    <div class="media-form-row my-3 ">
                                                        @php
                                                            $mediaUrl = asset('storage/' . $mediaItem->media);
                                                        @endphp
                                                        <input type="hidden"
                                                            name="media_files[{{ $soal->id }}][{{ $key_media }}][id]"
                                                            value="{{ $mediaItem->id }}">
                                                        <!-- Media Preview Section -->
                                                        <div class="card p-2 text-center" style="width: 40%;height: auto;">
                                                            @if (Str::endsWith($mediaItem->media, ['.jpg', '.jpeg', '.png', '.webp']))
                                                                <img src="{{ $mediaUrl }}" alt="Media Gambar"
                                                                    class="img-fluid rounded" style="max-height: 200px;">
                                                            @elseif (Str::endsWith($mediaItem->media, ['.mp3', '.wav']))
                                                                <audio controls class="w-100">
                                                                    <source src="{{ $mediaUrl }}" type="audio/mpeg">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                            @endif
                                                        </div>


                                                        <div class="row align-items-center">
                                                            <div class="col-md-6 m-1">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        name="media_files[{{ $soal->id }}][{{ $key_media }}][file]"
                                                                        id="mediaFile_{{ $soal->id }}_{{ $key_media }}">
                                                                    <label class="custom-file-label"
                                                                        for="mediaFile_{{ $soal->id }}_{{ $key_media }}">{{ basename($mediaItem->media) }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-1">
                                                                <input type="text" class="form-control"
                                                                    name="media_files[{{ $soal->id }}][{{ $key_media }}][keterangan]"
                                                                    value="{{ $mediaItem->keterangan }}"
                                                                    placeholder="Keterangan Media">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <button type="button" data-id="{{ $mediaItem->id }}"
                                                                    class="btn btn-danger btn-sm px-3 media-remove-btn">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>                                        <div class="d-flex flex-column  opsi-container">
                                            @foreach ($opsi[$soal->id] as $key_opsi => $item)
                                                <div class="form-check d-flex align-items-center my-1">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="soal_quiz[{{ $soal->id }}][jawaban_benar]"
                                                        value="{{ $key_opsi }}" {{ $item->is_true ? 'checked' : '' }}>

                                                    <input type="text" class="form-control me-2 flex-grow-1"
                                                        name="soal_quiz[{{ $soal->id }}][pilihan][{{ $key_opsi }}]"
                                                        value="{{ $item->opsi }}">

                                                    @if ($opsi_count > 2)
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-opsi px-3 flex-shrink-0"
                                                            data-id="{{ $item->id ?? '' }}">-</button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-success btn-sm tambah-opsi mt-2"
                                            data-key="{{ $soal->id }}">Tambah Pilihan</button>
                                        <button type="button" class="btn btn-danger btn-sm remove-soal mt-2"
                                            data-id="{{ $soal->id }}">Hapus Soal</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                let soalCount = 0;

                $('#tambah-soal').on('click', function(e) {
                    e.preventDefault();
                    soalCount++;
                    const newSoalKey = 'new_' + soalCount;

                    const newSoal = `
            <div class="card mb-4 shadow-sm soal-container">
                <div class="card-body" style="background-color: rgb(224, 239, 244)">
                    <input type="text" class="form-control mb-2" name="soal_quiz[${newSoalKey}][soal]" placeholder="Soal Baru">

                     <div class="media-forms-container">
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary btn-sm add-media-btn" data-soal-id="${newSoalKey}">
                                <i class="fas fa-plus"></i> Tambah Media
                            </button>
                        </div>
                    </div>
                    

                    <div class="d-flex flex-column gap-2 opsi-container">
                        ${generateOpsi(newSoalKey, 0, false)}
                        ${generateOpsi(newSoalKey, 1, false)}
                    </div>
                    <button type="button" class="btn btn-success btn-sm tambah-opsi mt-2" data-key="${newSoalKey}">Tambah Pilihan</button>
                    <button type="button" class="btn btn-danger btn-sm remove-soal mt-2">Hapus Soal</button>
                </div>
            </div>`;
                    $('.soal-container-wrapper').append(newSoal);
                });                function generateOpsi(key, index, showRemove = true) {
                    const label = String.fromCharCode(65 + index);
                    return `
            <div class="form-check d-flex align-items-center my-1">
                <input class="form-check-input me-2" type="radio"
                       name="soal_quiz[${key}][jawaban_benar]" value="${index}">
                <input type="text" class="form-control me-2 flex-grow-1"
                       name="soal_quiz[${key}][pilihan][${index}]"
                       placeholder="Opsi ${label}">
                ${showRemove ? `<button type="button" class="btn btn-danger btn-sm remove-opsi px-3 flex-shrink-0">-</button>` : ''}
            </div>`;
                }

                $(document).on('click', '.tambah-opsi', function() {
                    const key = $(this).data('key');
                    const container = $(this).siblings('.opsi-container');
                    const currentCount = container.children().length;
                    container.append(generateOpsi(key, currentCount, true));                    if (currentCount + 1 > 2) {
                        container.find('.form-check').each(function() {
                            if ($(this).find('.remove-opsi').length === 0) {
                                $(this).append(
                                    `<button type="button" class="btn btn-danger btn-sm remove-opsi px-3 flex-shrink-0">-</button>`
                                );
                            }
                        });
                    }
                });

                $(document).on('click', '.remove-opsi', function() {
                    const button = $(this);
                    const opsiId = button.data('id'); // Ambil ID dari tombol
                    const container = button.closest('.opsi-container');
                    const formCheck = button.closest('.form-check');

                    if (opsiId) {
                        $.ajax({
                            url: `/admin/quiz/soal/delete_opsi/${opsiId}`,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                formCheck.remove();
                                const remaining = container.children('.form-check').length;
                                if (remaining <= 2) {
                                    container.find('.remove-opsi').remove();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                            }
                        });
                    } else {
                        formCheck.remove();
                        const remaining = container.children('.form-check').length;
                        if (remaining <= 2) {
                            container.find('.remove-opsi').remove();
                        }
                    }
                });


                $(document).on('click', '.remove-soal', function() {
                    const button = $(this);
                    const soalId = button.data('id'); // Ambil ID dari tombol
                    const container = button.closest('.soal-container');

                    if (soalId) {
                        $.ajax({
                            url: `/admin/quiz/soal/delete_soal/${soalId}`,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                container.remove();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                            }
                        });
                    } else {
                        container.remove();
                    }


                });

                $('#form-soal').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this)[0];
                    const formData = new FormData(form);

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#simpan-soal').text('Menyimpan...').prop('disabled', true);
                        },
                        success: function(res) {
                            if (res.status === 'error') {
                                swal.fire({
                                    title: 'Gagal!',
                                    text: res.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Soal berhasil disimpan.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            let message = 'Terjadi kesalahan.';
                            if (xhr.responseJSON?.errors) {
                                const errors = xhr.responseJSON.errors;
                                message = '<ul style="text-align: left;">';
                                for (const key in errors) {
                                    errors[key].forEach(err => {
                                        message += `<li>${err}</li>`;
                                    });
                                }
                                message += '</ul>';
                            } else if (xhr.responseJSON?.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                title: 'Gagal!',
                                html: message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        },
                        complete: function() {
                            $('#simpan-soal').text('Simpan').prop('disabled', false);
                        }
                    });
                });
            });

            $(document).ready(function() {
                // Handle "Add Media" button click
                $(document).on('click', '.add-media-btn', function() {
                    const button = $(this);
                    const container = button.closest('.media-forms-container');
                    // CHANGE THIS LINE
                    const soalId = button.data('soal-id'); // Use the data-soal-id attribute directlyF
                    // Calculate the new index
                    const newIndex = container.find('.media-form-row').length;

                    // Create a new media row
                    // In the add-media-btn click handler function
                    const newRow = `
                        <div class="media-form-row my-3">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" 
                                                name="media_files[${soalId}][${newIndex}][file]"
                                                id="mediaFile_${soalId}_${newIndex}" required>
                                            <label class="custom-file-label" for="mediaFile_${soalId}_${newIndex}">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"
                                            name="media_files[${soalId}][${newIndex}][keterangan]"
                                            value=""
                                            placeholder="Keterangan Media">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm px-3 media-remove-btn">-</button>
                                    </div>
                                </div>
                        </div>
                        `;
                    // Append the new row to the container
                    container.append(newRow);
                });

                // Update label on file selection
                $(document).on('change', '.custom-file-input', function(e) {
                    var fileName = e.target.files[0]?.name;
                    $(this).next('.custom-file-label').html(fileName);
                });


                // Handle "Remove Media" button click
                $(document).on('click', '.media-remove-btn', function() {
                    const button = $(this);
                    const mediaRow = button.closest('.media-form-row');
                    const mediaId = button.data('id');

                    if (mediaId) {
                        $.ajax({
                            url: '/admin/quiz/soal/delete_media/' + mediaId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                mediaRow.remove();
                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan saat menghapus media!');
                            }
                        });
                    } else {
                        mediaRow.remove();
                    }
                });
            });
        </script>
    @endsection
