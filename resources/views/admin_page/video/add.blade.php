<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addModuleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('/admin/video/store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-group">
                            <label for="nama">Materi</label>
                            <select class="form-control" name="id_materi" required>
                                @foreach ($materi as $item)
                                    <option value="{{$item->id}}">{{$item->judul}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Url Video</label>
                        <input type="text" class="form-control" name="url_video" required>
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
