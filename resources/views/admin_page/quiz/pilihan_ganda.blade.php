@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <div class="col-1 m-0 p-0 text-end">
                        <a href="{{ url('/admin/quiz/'.$type_soal->quiz_id)}}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
                    </div> 
                    <h3 class="card-title">Informasi Soal</h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;">
                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Judul Quiz</strong>
                                <p>{{$type_soal->judul_quiz}} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Tipe soal</strong>
                                <p> Pilihan Ganda </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Jumlah Soal</strong>
                                <p>{{$type_soal->jumlah_soal}}</p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Jumlah Soal Saat ini</strong>
                                <p>{{$type_soal->jumlah_soal_now}}</p>
                            </td>
                        </tr>
                    </table> 
            </div>
        </div>

        <form method="POST" action="{{url('/admin/quiz/soal/create_pilgan')}}" id="form-soal" enctype="multipart/form-data">
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
                        @foreach($soal_quiz as $soal)
                            @php 
                            $opsi_count = count($opsi[$soal->id]);
                            @endphp
                            <div class="card mb-4 shadow-sm soal-container">
                                <div class="card-body" style="background-color: rgb(224, 239, 244)">
                                    <input type="text" class="form-control mb-2" name="soal_quiz[{{ $soal->id }}][soal]" value="{{ $soal->soal }}">
                                    
                                    <label>Upload Media (optional):</label>
                                    <input type="file" name="soal_quiz[{{ $soal->id }}][media]" class="form-control mb-2">
        
                                    <div class="d-flex flex-column gap-2 opsi-container">
                                        @foreach($opsi[$soal->id] as $key_opsi => $item)
                                            <div class="form-check d-flex align-items-center my-1">
                                                <input class="form-check-input me-2" type="radio"
                                                    name="soal_quiz[{{ $soal->id }}][jawaban_benar]"
                                                    value="{{ $key_opsi }}" {{ $item->is_true ? 'checked' : '' }}>
        
                                                <input type="text" class="form-control me-2 w-50"
                                                    name="soal_quiz[{{ $soal->id }}][pilihan][{{ $key_opsi }}]"
                                                    value="{{ $item->opsi }}">
        
                                                @if($opsi_count > 2)
                                                    <button type="button" class="btn btn-danger btn-sm remove-opsi px-3 mx-1 "  data-id="{{ $item->id ?? '' }}">-</button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm tambah-opsi mt-2" data-key="{{ $soal->id }}">Tambah Pilihan</button>
                                    <button type="button" class="btn btn-danger btn-sm remove-soal mt-2" data-id="{{$soal->id}}">Hapus Soal</button>
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
$(document).ready(function () {
    let soalCount = 0;

    $('#tambah-soal').on('click', function (e) {
        e.preventDefault();
        soalCount++;
        const newSoalKey = 'new_' + soalCount;

        const newSoal = `
            <div class="card mb-4 shadow-sm soal-container">
                <div class="card-body" style="background-color: rgb(224, 239, 244)">
                    <input type="text" class="form-control mb-2" name="soal_quiz[${newSoalKey}][soal]" placeholder="Soal Baru">
                    
                    <label>Upload Media (optional):</label>
                    <input type="file" name="soal_quiz[${newSoalKey}][media]" class="form-control mb-2">

                    <div class="d-flex flex-column gap-2 opsi-container">
                        ${generateOpsi(newSoalKey, 0, false)}
                        ${generateOpsi(newSoalKey, 1, false)}
                    </div>
                    <button type="button" class="btn btn-success btn-sm tambah-opsi mt-2" data-key="${newSoalKey}">Tambah Pilihan</button>
                    <button type="button" class="btn btn-danger btn-sm remove-soal mt-2">Hapus Soal</button>
                </div>
            </div>`;
        $('.soal-container-wrapper').append(newSoal);
    });

    function generateOpsi(key, index, showRemove = true) {
        const label = String.fromCharCode(65 + index);
        return `
            <div class="form-check d-flex align-items-center my-1">
                <input class="form-check-input me-2" type="radio"
                       name="soal_quiz[${key}][jawaban_benar]" value="${index}">
                <input type="text" class="form-control me-2 w-50"
                       name="soal_quiz[${key}][pilihan][${index}]"
                       placeholder="Opsi ${label}">
                ${showRemove ? `<button type="button" class="btn btn-danger btn-sm remove-opsi px-3 mx-1">-</button>` : ''}
            </div>`;
    }

    $(document).on('click', '.tambah-opsi', function () {
            const key = $(this).data('key');
            const container = $(this).siblings('.opsi-container');
            const currentCount = container.children().length;
            container.append(generateOpsi(key, currentCount, true));

            if (currentCount + 1 > 2) {
                container.find('.form-check').each(function () {
                    if ($(this).find('.remove-opsi').length === 0) {
                        $(this).append(`<button type="button" class="btn btn-danger btn-sm remove-opsi px-3 mx-1">-</button>`);
                    }
                });
            }
        });

        $(document).on('click', '.remove-opsi', function () {
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
                success: function (res) {
                    formCheck.remove();
                    const remaining = container.children('.form-check').length;
                    if (remaining <= 2) {
                        container.find('.remove-opsi').remove();
                    }
                },
                error: function (xhr) {
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


    $(document).on('click', '.remove-soal', function () {
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
                success: function (res) {
                    container.remove();
                },
                error: function (xhr) {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                }
            });
        } else {
            container.remove();
        }


    });

    $('#form-soal').on('submit', function (e) {
        e.preventDefault();
        const form = $(this)[0];
        const formData = new FormData(form);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#simpan-soal').text('Menyimpan...').prop('disabled', true);
            },
            success: function (res) {
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
            error: function (xhr) {
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
            complete: function () {
                $('#simpan-soal').text('Simpan').prop('disabled', false);
            }
        });
    });
});

</script>
@endsection
