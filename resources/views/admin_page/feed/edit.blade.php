<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="addModuleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit Feed</h5>
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
                        <img src="{{ Storage::url($item->file_media ?? '')}}" id="edit-tumbnail" alt="" class="ml-2 mt-2" style="width: 100px">
                    </div>
                    <div class="form-group">
                        <label for="nama">Judul</label>
                        <input type="text" class="form-control" name="judul_activity" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Deskripsi</label>
                        <textarea class="form-control" rows="4" name="deskripsi_activity" required></textarea>
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


