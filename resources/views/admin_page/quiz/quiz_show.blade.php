@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <a href="{{ url('/admin/quiz')}}" type="button" class="btn btn-secondary mx-2">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3 class="card-title">Setting Quiz</h3>
                </div>
                <div class="card-body">
                    <div class="my-2">
                        <form method="post" action="{{ url('/admin/quiz/update/' . $quiz->quiz_id) }}">
                            @csrf
                            @method('PUT')
                        <div class="row">
                            <!-- Judul -->
                            <div class="form-group col-12">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" value="{{$quiz->judul}}" id="judul" name="judul" required>
                            </div>
                        
                            <!-- Waktu -->
                            <div class="form-group col-6">
                                <label for="waktu_pengerjaan">Waktu Pengerjaan (menit)</label>
                                <input type="number" class="form-control" value="{{$quiz->waktu_pengerjaan}}" id="waktu_pengerjaan" name="waktu_pengerjaan" required>
                            </div>
                        
                            <!-- Type Quiz -->
                            <div class="form-group col-6">
                                <label for="type">Type Quiz</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="posttest" {{ $quiz->type == 'posttest' ? 'selected' : '' }}>Post Test</option>
                                    <option value="pretest" {{ $quiz->type == 'pretest' ? 'selected' : '' }}>Pre Test</option>
                                </select>
                            </div>
                            
                        
                            <!-- Level -->
                            <div class="form-group col-12">
                                <label for="level">Level</label>
                                <select class="form-control" name="level_id" id="level">
                                    <option value="">-- Pilih Level --</option>
                                    @foreach ($level as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ $item->id == old('level_id', $quiz->level_id) ? 'selected' : '' }}>
                                            {{ $item->nama_level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                        
                            <!-- Materi -->
                            <div class="form-group col-12">
                                <label for="materi">Materi</label>
                                <select class="form-control" name="materi_id" id="materi" disabled>
                                    <option value="">-- Pilih Level Terlebih Dahulu --</option>
                                    @foreach ($materi as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ $item->id == old('materi_id', $quiz->materi_id) ? 'selected' : '' }}>
                                            {{ $item->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                              <div class="form-group col-12">
                                <label for="waktu_pengerjaan">Aktif</label>
                                @php
                                    if($quiz->is_active == 1) {
                                        $status = 'Aktif';
                                    } else {
                                        $status = 'Tidak Aktif';
                                    }
                                @endphp
                                <input type="text" class="form-control" value="{{$status}}" id="is_active" name="is_active" style="width: 50%" readonly>
                            </div>
                        
                            <!-- tombol -->
                            <div class="my-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>

                    </div>
                </div>
                <div class="card col-12 mt-2">
                    <div class="card-header d-flex  align-items-center">
                        <h3 class="card-title">Type Soal</h3>
                    </div>
                    <div class="card-body">  
                    <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                        <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                        <thead style="background-color: #578FCA; color: white;">
                            <tr>
                                <th>Tipe Soal</th>
                                <th >Jumlah Soal</th>
                                <th>Skor per Soal </th>
                                <th>Jumlah Soal saat ini </th>
                                <th>Bobot (%)</th>
                                <th>Total Skor </th>
                                
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="type-soal-body">
                            @foreach($type_soal as $item)
                            @php
                                if($item->tipe_soal == 'pilihan_ganda') {
                                    $tipe = 'Pilihan Ganda';
                                } elseif ($item->tipe_soal == 'isian_singkat') {
                                    $tipe = 'Isian Singkat';
                                } else {
                                    $tipe = "Uraian";
                                }
                            @endphp
                            <tr>
                                <input type="hidden" value="{{$item->id}}" class="id" required>
                                <td> {{$tipe}} </td>
                                <td> 
                                    <input min="0" type="number" style="max-width: 5vw" value="{{$item->jumlah_soal}}" class="jumlah_soal" onchange="updateTypeSoal(this)" required>
                                </td>
                                <td> 
                                    <input min="0" type="number" style="max-width: 8vw" value="{{$item->skor_per_soal}}" class="skor_per_soal" onchange="updateTypeSoal(this)" required>
                                </td>
                                <td>{{$item->jumlah_soal_now}}</td>
                                <td class="total-skor"> {{$item->total_skor}} </td>
                                <td><p class="bobot">0%</p></td>
                                <td>
                                    <a href="{{ url('/admin/quiz/soal/'.$item->id) }}" class="kelola-soal-btn btn btn-primary" >Kelola Soal</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            
                            <!-- Tambahkan footer untuk total -->
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;"><strong>Total Skor Semua:</strong></td>
                                    <td id="grand-total-skor">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            
                    </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
   $(document).ready(function() {
    const $level  = $('#level');
    const $materi = $('#materi');
    const $type   = $('#type');

    updateTotalAndBobot();

    // Fungsi untuk atur state awal dari #materi
    function updateMateriState() {
        if ($type.val() === 'pretest') {
            $materi.prop('disabled', true);
        } else {
            if ($level.val()) {
                $materi.prop('disabled', false);
            } else {
                $materi.prop('disabled', true);
            }
        }
    }

    // Ketika Level berubah
    $level.on('change', function() {
        const levelId = $(this).val();

        if (!levelId) {
            $materi.html('<option value="">-- Pilih Level Terlebih Dahulu --</option>')
                   .prop('disabled', true);
            return;
        }

        $.getJSON('/admin/quiz/materi/' + levelId, function(data) {
            let options = '<option value="">-- Pilih Materi --</option>';
            $.each(data, function(i, m) {
                options += `<option value="${m.id}">${m.judul}</option>`;
            });
            $materi.html(options);

            updateMateriState(); // cek ulang apakah perlu disabled atau tidak
        });
    });

    $type.on('change', updateMateriState);

    updateMateriState();
});

function updateTypeSoal(element) {
    const row = $(element).closest('tr');
    const id = row.find('.id').val();
    const jumlah_soal = row.find('.jumlah_soal').val();
    const skor_per_soal = row.find('.skor_per_soal').val();

    row.css('opacity', '0.5');
    $.ajax({
        url: '{{ route("updateType") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            id: id,
            jumlah_soal: jumlah_soal,
            skor_per_soal: skor_per_soal
        },
        success: function(response) {
            if (response.status === 'success') {
                data = response.data;
                row.find('.total-skor').text(data.total_skor);
                updateTotalAndBobot();
            } else {
                alert('Gagal memperbarui data: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
        },complete: function() {
            row.css('opacity', '1');
        }
    });
}

function updateTotalAndBobot() {
    let grandTotalSkor = 0;

    $('tbody tr').each(function() {
        const jumlahSoal = parseInt($(this).find('.jumlah_soal').val()) || 0;
        const skorPerSoal = parseInt($(this).find('.skor_per_soal').val()) || 0;
        const totalSkor = jumlahSoal * skorPerSoal;

        $(this).find('.total-skor').text(totalSkor);
        grandTotalSkor += totalSkor;

        // ===== Bagian disable/enable tombol "Kelola Soal" =====
        const kelolaButton = $(this).find('.kelola-soal-btn');
        if (jumlahSoal === 0) {
            kelolaButton.addClass('disabled').attr('aria-disabled', 'true');
        } else {
            kelolaButton.removeClass('disabled').removeAttr('aria-disabled');
        }

    });

    $('#grand-total-skor').text(grandTotalSkor);

    $('tbody tr').each(function() {
        const rowTotalSkor = parseInt($(this).find('.total-skor').text()) || 0;
        const bobot = grandTotalSkor ? ((rowTotalSkor / grandTotalSkor) * 100).toFixed(2) : 0;
        $(this).find('.bobot').text(bobot + '%');
    });
}

</script>
@endsection
