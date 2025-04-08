<div class="modal fade" id="editLevel" tabindex="-1" role="dialog" aria-labelledby="editLevelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Edit Level</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form method="POST" >
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama Level</label>
                    <input type="text" class="form-control" id="edit-nama" name="nama_level" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" class="form-control" id="edit-deskripsi" name="deskripsi_level" required>
                </div>
                <div class="form-group">
                    <label for="warna">Pilih Warna</label>
                    <input type="color" class="form-control" id="edit-warna" name="warna"  required>
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