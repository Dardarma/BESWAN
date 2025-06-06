<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="addModuleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit Galeri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="thumbnail">Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_media" name="file_media" >
                            <label class="custom-file-label" for="file_media">Upload Image</label>
                        </div>
                        <br>
                        <img id="preview-image" src="" alt="Preview" style="max-width: 200px; display: none;" class="p-1">
                    </div>
                    <div class="form-group">
                        <label for="nama">Title</label>
                        <input type="text" class="form-control" id="judul" name="judul_activity" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Description</label>
                        <textarea class="form-control" rows="4" id="deskripsi_activity" name="deskripsi_activity" required></textarea>
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


