<div class="modal fade" id="editQuiz" tabindex="-1" role="dialog" aria-labelledby="editQuizLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit Quiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('quiz/update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id">
                
                    <div class="form-group">
                        <label for="nama">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                
                    <div class="form-group">
                        <label for="nama">Waktu Pengerjaan (menit)</label>
                        <input type="number" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan" required>
                    </div>
                
                    <div class="form-group">
                        <label>Type Quiz</label>
                        <select class="form-control" name="type_quiz" >
                            <option value="post_test">Post Test</option>
                            <option value="pre_test">Pre Test</option>
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label>Type Soal</label>
                        <select class="form-control" name="type_soal">
                            <option value="pilihan_ganda">Pilihan Ganda</option>
                            <option value="uraian">Uraian</option>
                            <option value="isian_singkat">Isian Singkat</option>
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="urutan_level">
                            @foreach ($level as $item)
                                <option value="{{$item->id}}">{{$item->urutan_level}}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label for="nama">Jumlah Soal</label>
                        <input type="number" class="form-control" id="jumlah_soal" name="jumlah_soal" min="0" required>
                    </div>
                
                    <div class="my-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                             
            </div>
        </div>
    </div>
  </div>
