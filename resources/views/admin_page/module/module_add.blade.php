<div class="modal fade" id="addModule" tabindex="-1" role="dialog" aria-labelledby="addModuleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add e-Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('/admin/module/add')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Deskripsi</label>
                        <textarea class="form-control" rows="4" name="deskripsi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Cover</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="tumbnail" required>
                            <label class="custom-file-label" for="thumbnail">Upload Image</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="url_file" required>
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="author" required>
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
