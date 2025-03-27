<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Add User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="post" action="{{ url('/admin/master/user/add') }}">
                  @csrf
                  <div class="form-group">
                      <label for="nama">nama</label>
                      <input type="text" class="form-control" id="" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="thumbnail">Profile Picture</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto_profil" name="foto_profil" required>
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
                          <textarea class="form-control" id="" name="alamat" rows="5" required></textarea>
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

<script>
  // Update label text when a file is selected
  document.querySelectorAll('.custom-file-input').forEach((inputElement) => {
      inputElement.addEventListener('change', (event) => {
          const fileName = event.target.files[0]?.name || "Upload Image";
          const labelElement = event.target.nextElementSibling;
          labelElement.textContent = fileName;
      });
  });
</script>