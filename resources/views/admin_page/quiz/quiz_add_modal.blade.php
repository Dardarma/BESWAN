<div class="modal fade" id="addQuiz" tabindex="-1" role="dialog" aria-labelledby="addQuizLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Quiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/admin/quiz/store') }}">
                    @csrf
                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>

                    <!-- Waktu -->
                    <div class="form-group">
                        <label for="waktu_pengerjaan">Waktu Pengerjaan (menit)</label>
                        <input type="number" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan"
                            required>
                    </div>

                    <!-- Type Quiz -->
                    <div class="form-group">
                        <label for="type">Type Quiz</label>
                        <select class="form-control" name="type" id="type">
                            <option value="posttest">Post Test</option>
                            <option value="pretest">Pre Test</option>
                        </select>
                    </div>

                    <!-- Level -->
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" name="level_id" id="level">
                            <option value=" ">-- Pilih Level --</option>
                            @foreach ($level as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_level }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Materi -->
                    <div class="form-group">
                        <label for="materi">Materi</label>
                        <select class="form-control" name="materi_id" id="materi" disabled>
                            <option value="">-- Pilih Level Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <!-- tombol -->
                    <div class="my-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>


<script>
    $(document).ready(function() {
        const $level = $('#level');
        const $materi = $('#materi');
        const $type = $('#type');

        // Ketika Level berubah
        $level.on('change', function() {
            const levelId = $(this).val();

            if (!levelId) {
                // reset dan disable materi
                $materi.html('<option value="">-- Pilih Level Terlebih Dahulu --</option>')
                    .prop('disabled', true);
                return;
            }

            // Fetch materi via AJAX
            $.getJSON('/admin/quiz/materi/' + levelId, function(data) {
                let options = '<option value="">-- Pilih Materi --</option>';
                $.each(data, function(i, m) {
                    options += `<option value="${m.id}">${m.judul}</option>`;
                });
                $materi.html(options);

                // Jika type pretest, tetap disable
                if ($type.val() === 'pretest') {
                    $materi.prop('disabled', true);
                } else {
                    $materi.prop('disabled', false);
                }
            });
        });

        // Ketika Type Quiz berubah
        $type.on('change', function() {
            if ($(this).val() === 'pretest') {
                // hanya level, jadi matikan materi
                $materi.prop('disabled', true);
            } else {
                // kalo posttest, materi aktif jika level sudah dipilih
                if ($level.val()) {
                    $materi.prop('disabled', false);
                }
            }
        });
    });
</script>
