<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Edit User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="post" action="{{ url('/admin/master/user/add') }}">
                  @csrf
                  <div class="form-group">
                      <label for="nama">nama</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="thumbnail">Foto Profile</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="foto_profil" required>
                        <label class="custom-file-label" for="foto_profil">Upload Image</label>
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="nama">Email</label>
                      <input type="email" class="form-control" id="" name="email" required>
                  </div>
                  <div class="form-group">
                      <label for="nama">password</label>
                      <input type="password" class="form-control" id="" name="password" required>
                  </div>
                  <div class="form-group">
                      <label for="nama">Role</label>
                      <select name="role" id="">
                          <option value="superadmin">Super Admin</option>
                          <option value="teacher">Teacher</option>
                          <option value="user">Student</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="nama">no HP</label>
                      <input type="number" class="form-control" id="" name="no_hp" required>
                  </div>
                  <div>
                      <div class="form-group">
                          <label for="nama">Tanggal Lahir</label>
                          <input type="date" class="form-control" id="" name="tanggal_lahir" required>
                      </div>
                      <div>
                          <label for="nama">Alamat</label>
                          <textarea class="form-control" id="alamat" name="alamat" rows="5" required></textarea>
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