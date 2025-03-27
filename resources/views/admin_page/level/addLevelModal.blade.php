<div class="modal fade" id="addLevel" tabindex="-1" role="dialog" aria-labelledby="addLevelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Add User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="post" action="{{url('admin/master/level/add')}}">
                  @csrf
                  <div class="form-group">
                      <label for="nama">Nama Level</label>
                      <input type="text" class="form-control" id="" name="nama_level" required>
                  </div>
                  <div class="form-group">
                      <label for="nama">Deskripsi</label>
                      <input type="text" class="form-control" id="" name="deskripsi_level" required>
                  </div>
                  <div class="form-group">
                    <label for="warna">Pilih Warna</label>
                    <input type="color" class="form-control" id="warna" name="warna" required>
                  </div>
                
                      <div class="my-2">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>