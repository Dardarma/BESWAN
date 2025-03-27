@extends('admin_page.layout')
@section('content')
    <div class="card mt-4 mx-3">
        <div class="card-header d-flex align-items-center">
            <a href="{{ url('/admin/quiz')}}" type="button" class="btn btn-secondary me-2">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h3 class="card-title mb-0 mx-1">Quiz</h3>
        </div>
        <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Data Quiz</h3>
                    <a 
                        class="btn btn-warning btn-sm btn-edit"
                        data-toggle ="modal"
                        data-target ="#editQuiz"
                        data-id="{{$quiz->id}}"
                        data-judul="{{$quiz->judul}}"
                        data-jumlah_soal="{{$quiz->jumlah_soal}}"
                        data-waktu_pengerjaan="{{$quiz->waktu_pengerjaan}}"
                        data-urutan_level="{{$quiz->urutan_level}}"
                        data-type_quiz="{{$quiz->type_quiz}}"
                        data-type_soal="{{$quiz->type_soal}}"
                    >
                        <i class="fa-solid fa-pencil"></i></a>
                    </a>
                </div>
                
                <table style="border:none">
                    <tr>
                        <td>Judul </td>
                        <td>: {{$quiz->judul}} </td>
                    </tr>
                    <tr>
                        <td>Jumlah soal</td>
                        <td>: {{$quiz->jumlah_soal}} </td>
                    </tr>
                    <tr>
                        <td>Waktu pengerjaan</td>
                        <td>: {{$quiz->waktu_pengerjaan}} menit </td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>: {{$quiz->urutan_level}} </td>
                    </tr>
                    @php
                        $type_quiz = $quiz->type_quiz;
                        if($type_quiz == 'post_test'){
                            $type_quiz = 'Post Test';
                        }elseif($type_quiz == 'pre_test'){
                            $type_quiz = 'Pre Test';
                        }
                    @endphp
                    <tr>
                        <td>Type Quiz</td>
                        <td>: {{$type_quiz}} </td>
                    </tr>
                    @php
                        $type_soal = $quiz->type_soal;
                        if($type_soal == 'pilihan_ganda'){
                            $type_soal = 'Pilihan Ganda';
                        }elseif($type_soal == 'uraian'){
                            $type_soal = 'Uraian';
                        }elseif($type_soal == 'isian_singkat'){
                            $type_soal = 'Isian Singkat';
                        }
                    @endphp
                    <tr>
                        <td>Type Soal</td>
                        <td>: {{$type_soal}} </td>
                    </tr>
                </table>
                
                <form id="quiz-form" action="{{url('/admin/soal/store')}}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center">
                        <input type="hidden" id="type_soal" value="{{$quiz->type_soal}}" name="type_soal">
                        <input type="hidden" id="id_quiz" value="{{$quiz->quiz_id}}" name="quiz_id">
                        <button id="tambah-soal" class="btn btn-primary mt-3" type="button"> Tambah Soal </button>
                        <button class="btn btn-success mt-3" type="submit"> Simpan Soal </button>
                    </div>
                    <div id="soal-container">
                        @foreach($soalData as $key => $value)
                        <input type="hidden" name="soal_quiz[{{$key}}][soal_id]" value="{{ $value['soal_id'] ?? '' }}">
                        <div class="card my-3 border border-primary-subtle soal-card" data-index="{{$key}}" data-id="{{ $value['soal_id'] ?? '' }}">
                            <div class="card-body">
                                <p class="card-text">Pertanyaan: 
                                    <input type="text" class="form-control" name="soal_quiz[{{$key}}][pertanyaan]" value="{{ $value['pertanyaan'] }}">
                                </p>
                                @if($quiz->type_soal == 'pilihan_ganda')
                                    <div class="opsi-container">
                                        @foreach($value['opsi'] as $key_opsi => $value_opsi)
                                            {{-- {{dd($value_opsi);}} --}}
                                            <input type="hidden" name="soal_quiz[{{$key}}][opsi][{{$key_opsi}}][id]" value="{{ $value_opsi['opsi_id'] ?? '' }}">

                                            <div class="form-check opsi-soal">
                                                <input class="form-check-input" type="radio" 
                                                    name="soal_quiz[{{$key}}][jawaban]" 
                                                    value="{{ $value_opsi['jawaban'] ?? '' }}"
                                                    @if(isset($value_opsi['is_true']) && $value_opsi['is_true']) checked @endif>
                                                <input type="text" class="form-control d-inline w-75" 
                                                    name="soal_quiz[{{$key}}][pilihan][{{$key_opsi}}]" 
                                                    value="{{ $value_opsi['jawaban'] ?? '' }}">
                                                @if($key_opsi > 1)
                                                    <button type="button" class="btn btn-danger btn-sm remove-opsi">Hapus</button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif                            
                                <button type="button" class="btn btn-success btn-sm tambah-opsi mt-2">Tambah Pilihan</button>
                                <button type="button" class="btn btn-danger btn-sm remove-soal mt-2" 
                                    data-id="{{ $value['soal_id'] ?? '' }}">Hapus soal</button>
                            </div>
                        </div>
                    @endforeach                                     
                    </div>
                </form>

    </div>
@include('admin_page.quiz.edit_quiz_modal')
@endsection

@section('script')
<script>
$('.btn-edit').click(function(){
    var id = $(this).data('id');
    var judul = $(this).data('judul');
    var jumlah_soal = $(this).data('jumlah_soal');
    var waktu_pengerjaan = $(this).data('waktu_pengerjaan');
    var id_level = $(this).data('id_level');
    var type_quiz = $(this).data('type_quiz');
    var type_soal = $(this).data('type_soal');

    var form = $('#editQuiz form');
    
    form.find('input[name="id"]').val(id);
    form.find('input[name="judul"]').val(judul);
    form.find('input[name="jumlah_soal"]').val(jumlah_soal);
    form.find('input[name="waktu_pengerjaan"]').val(waktu_pengerjaan);
    form.find('select[name="urutan_level"]').val(id_level);
    form.find('select[name="type_quiz"]').val(type_quiz);
    form.find('select[name="type_soal"]').val(type_soal);
});

$(document).ready(function () {
    let soalIndex = 0;

    $("#tambah-soal").click(function () {
        let jenisSoal = $("#type_soal").val();
        let soalHtml = '';

        if (jenisSoal === "pilihan_ganda") {
            soalHtml = `
                <div class="card my-3 border border-primary-subtle soal-card" data-index="${soalIndex}">
                    <div class="card-body">
                        <p class="card-text">Pertanyaan: 
                            <input type="text" class="form-control" name="soal_quiz[${soalIndex}][pertanyaan]" placeholder="Masukkan pertanyaan">
                        </p>

                        <div class="opsi-container">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="soal_quiz[${soalIndex}][jawaban]" value="">
                                <input type="text" class="form-control d-inline w-75" name="soal_quiz[${soalIndex}][pilihan][]" placeholder="Pilihan 1">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="soal_quiz[${soalIndex}][jawaban]" value="">
                                <input type="text" class="form-control d-inline w-75" name="soal_quiz[${soalIndex}][pilihan][]" placeholder="Pilihan 2">
                            </div>
                        </div>

                        <button type="button" class="btn btn-success btn-sm tambah-opsi mt-2">Tambah Pilihan</button>
                        <button type="button" class="btn btn-danger btn-sm remove-soal mt-2">Hapus soal</button>
                    </div>
                </div>`;
        } else if (jenisSoal === "isian_singkat") {
            soalHtml = `
                <div class="card my-3 border border-primary-subtle soal-card" data-index="${soalIndex}">
                    <div class="card-body">
                        <p class="card-text">
                            <input type="text" class="form-control" name="soal_quiz[${soalIndex}][pertanyaan]" placeholder="Masukkan pertanyaan">
                        </p>
                        <button type="button" class="btn btn-danger btn-sm remove-soal mt-2">Hapus soal</button>
                    </div>
                </div>`;
        }else if (jenisSoal === "uraian"){
            soalHtml = `
                <div class="card my-3 border border-primary-subtle soal-card" data-index="${soalIndex}">
                    <div class="card-body">
                        <p class="card-text">
                            <input type="text" class="form-control" name="soal_quiz[${soalIndex}][pertanyaan]" placeholder="Masukkan pertanyaan">
                        </p>
                        <button type="button" class="btn btn-danger btn-sm remove-soal mt-2">Hapus soal</button>
                    </div>
                </div>`;
        }

        $("#soal-container").append(soalHtml);
        soalIndex++;
    });

    // Update value radio button saat input teks diubah
    $(document).on('input', '.opsi-container input[type="text"]', function() {
        let value = $(this).val();
        $(this).siblings('input[type="radio"]').val(value);
    });

    // Tambah pilihan baru
    $(document).on('click', '.tambah-opsi', function() {
        let container = $(this).siblings('.opsi-container');
        let index = container.children('.form-check').length;
        let soalIndex = $(this).closest('.soal-card').data('index');

        let opsiHtml = `
            <div class="form-check">
                <input class="form-check-input" type="radio" name="soal_quiz[${soalIndex}][jawaban]" value="">
                <input type="text" class="form-control d-inline w-75" name="soal_quiz[${soalIndex}][pilihan][]" placeholder="Pilihan ${index + 1}">
                <button type="button" class="btn btn-danger btn-sm remove-opsi">Hapus</button>
            </div>`;

        container.append(opsiHtml);
    });



    $(document).on("click", ".remove-soal", function () {
    let soalCard = $(this).closest(".soal-card");
    let soalId = soalCard.data("id");

    if (soalId) {
        Swal.fire({
            title: "Yakin ingin menghapus soal ini?",
            text: "Data akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('delete-soal', ':id') }}`.replace(':id', soalId),
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Kirim CSRF token
                    },
                    success: function (response) {
                        Swal.fire(
                            "Terhapus!",
                            "Soal berhasil dihapus.",
                            "success"
                        );
                        soalCard.remove(); 
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Gagal!",
                            xhr.responseJSON?.message || "Terjadi kesalahan!",
                            "error"
                        );
                    }
                });
            }
        });
    } else {
        soalCard.remove();
    }
});


$(document).on("click", ".remove-opsi", function () {
    const opsi = $(this).closest(".opsi-soal");
    const opsiId = $('input[name="soal_quiz[{{$key}}][opsi][{{$key_opsi}}][id]"]').val();
    console.log(opsiId);


    const deleteUrl = @json(route('delete-opsi', ':id'));

    if (opsiId) {
        Swal.fire({
            title: "Yakin ingin menghapus opsi ini?",
            text: "Data akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl.replace(':id', opsiId),
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire(
                            "Terhapus!",
                            "Opsi berhasil dihapus.",
                            "success"
                        );
                        opsi.fadeOut(300, () => opsi.remove());
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Gagal!",
                            xhr.responseJSON?.message || "Terjadi kesalahan!",
                            "error"
                        );
                    }
                });
            }
        });
    } else {
        opsi.fadeOut(300, () => opsi.remove());
    }
});

});

</script>
@endsection
