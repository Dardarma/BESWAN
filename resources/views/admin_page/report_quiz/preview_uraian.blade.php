@extends('admin_page.layout')
@section('content')
    <div class="row mx-2 d-flex justify-content-center">


        <div class="col-10 my-3">
            <div class="card shadow" style=" background-color: #f0f4ff8b;">
                <div class="card-header align-items-center row">
                    <div class="d-flex align-items-center col-6">
                        <a href="{{ url('admin/quiz_report/list/'.$id_quiz->quiz_id)}}" class="btn btn-secondary mx-2">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0">Preview Soal Uraian</h5>
                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url('admin/quiz_report/isian_singkat/' . $id) }}" class="btn btn-primary mx-2"
                            style="border-radius: 5px;">
                            Isian Singkat
                        </a>
                        <a href="{{ url('admin/quiz_report/pilihan_ganda/' . $id) }}" class="btn btn-primary"
                            style="border-radius: 5px;">
                            Pilihan Ganda
                        </a>
                    </div>
                </div>


                <div class="card-body p-4">
                    @foreach ($soal as $items)
                        <div class="card my-2 shadow-sm soal-container" style="border-radius: 20px;">
                            <div class="card-body" style="background-color: #AADDFF; border-radius: 20px;">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 fw-bold fs-4">{{ $items->urutan_soal }}.</div>
                                    <div class="flex-grow-1">{!! $items->soal !!}</div>

                                </div>


                                <div class="d-flex flex-column gap-2 opsi-container ps-4">
                                    <label>Jawab:</label>
                                    <div>{{ $items->opsi }}</div>

                                    <form method="POST">
                                        @csrf
                                        @method('PUT')

                                        <label for="skorInput">Skor:</label>
                                        <input type="number" id="skorInput" min="0"
                                            max="{{ $items->skor_per_soal }}" name="skor" class="form-control"
                                            value="{{ $items->nilai }}" style="width: 100px;" onchange="updateSkor(this)"
                                            onkeydown="if(event.key === 'Enter'){ event.preventDefault(); updateSkor(this); }">

                                        <input type="hidden" name="soal_terpilih_id"
                                            value="{{ $items->soal_terpilih_id }}">
                                    </form>

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
            function updateSkor(element) {
                const form = $(element).closest('form')[0];
                const skorInput = form.querySelector('input[name="skor"]');
                const id = form.querySelector('input[name="soal_terpilih_id"]').value;

                const maxSkor = parseInt(skorInput.getAttribute('max'));
                let skorValue = parseInt(skorInput.value);

                // Validasi manual jika melebihi max
                if (skorValue > maxSkor) {
                    skorInput.value = maxSkor;
                    skorValue = maxSkor;
                }

                $(form).css('display', 'none');

                $.ajax({
                    url: '{{ url('admin/quiz_report/update_skor') }}',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        soal_terpilih_id: id,
                        skor: skorValue
                    },
                    success: function(response) {
                        $(form).css('display', 'block');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Gagal memperbarui skor');
                        $(form).css('display', 'block');
                    }
                });
            }

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Cegah submit bawaan
                });
            });
        </script>
    @endsection
