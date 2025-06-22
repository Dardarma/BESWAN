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
                <form method="post" action="{{ url('/admin/module/add') }}" enctype="multipart/form-data" id="addModuleForm">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Description</label>
                        <textarea class="form-control" rows="4" name="deskripsi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Cover</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="tumbnail" accept="image/*" required>
                            <label class="custom-file-label" for="thumbnail">Upload Image</label>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="url_file" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                        <small class="text-muted">Format: PDF, DOC, DOCX, PPT, PPTX (Max: 10MB)</small>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="author" required>
                    </div>
                    <div class="form-group">
                        <label for="author">publication</label>
                        <input type="date" class="form-control" name="terbitan" required>
                    </div>
                    <div class="my-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
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
            const fileName = event.target.files[0]?.name || "Choose file";
            const labelElement = event.target.nextElementSibling;
            labelElement.textContent = fileName;
        });
    });

    // Form validation before submit
    document.getElementById('addModuleForm').addEventListener('submit', function(e) {
        const thumbnailFile = document.getElementById('thumbnail').files[0];
        const documentFile = document.getElementById('file').files[0];
        
        if (!thumbnailFile) {
            e.preventDefault();
            alert('Silakan pilih file cover terlebih dahulu');
            return false;
        }
        
        if (!documentFile) {
            e.preventDefault();
            alert('Silakan pilih file dokumen terlebih dahulu');
            return false;
        }

        // Validate file sizes
        if (thumbnailFile.size > 2 * 1024 * 1024) { // 2MB
            e.preventDefault();
            alert('Ukuran file cover maksimal 2MB');
            return false;
        }

        if (documentFile.size > 10 * 1024 * 1024) { // 10MB
            e.preventDefault();
            alert('Ukuran file dokumen maksimal 10MB');
            return false;
        }

        // Show loading state
        document.getElementById('submitBtn').innerHTML = 'Menyimpan...';
        document.getElementById('submitBtn').disabled = true;
    });

    // Reset form when modal is closed
    $('#addModule').on('hidden.bs.modal', function () {
        document.getElementById('addModuleForm').reset();
        document.querySelectorAll('.custom-file-label').forEach(label => {
            if (label.getAttribute('for') === 'thumbnail') {
                label.textContent = 'Upload Image';
            } else {
                label.textContent = 'Choose file';
            }
        });
        document.getElementById('submitBtn').innerHTML = 'Simpan';
        document.getElementById('submitBtn').disabled = false;
    });
</script>
