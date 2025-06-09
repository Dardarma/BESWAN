@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12 mt-3">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-1 m-0 p-0 text-end">
                            <a href="{{ url('/admin/article') }}" class="btn btn-secondary"><i
                                    class="fa-solid fa-arrow-left"></i></a>
                        </div>
                        <div class="col-6 m-0 p-0">
                            <h2>Edit Materi</h2>
                        </div>
                    </div>
                </div>
                <!-- form start -->
                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/article/update/' . $article->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Judul</label>
                            <input type="text" class="form-control" name="judul" required
                                value="{{ old('judul', $article->judul) }}">
                        </div>

                        <label>Level</label>
                        <select class="form-control select2" style="width: 100%;" name="id_level" required>
                            @foreach ($level as $lvl)
                                <option value="{{ $lvl->id }}"
                                    {{ old('id_level', $article->id_level) == $lvl->id ? 'selected' : '' }}>
                                    {{ $lvl->urutan_level }} - {{ $lvl->nama_level }}
                                </option>
                            @endforeach
                        </select>


                        <div class="form-group">
                            <label for="deskripsi">Description</label>
                            <textarea class="form-control" name="deskripsi" required>{{ old('deskripsi', $article->deskripsi) }}</textarea>
                        </div>

                        <textarea id="classic" style="min-height: 500px" name="konten">
                              {{ old('konten', $article->konten) }}
                            </textarea>

                        <div class="form-group my-3">
                            <button type="submit" class="btn btn-success">simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        tinymce.init({
            selector: 'textarea#classic',
            height: 500,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'image | removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',

            images_upload_url: '/admin/article/upload-image',
            automatic_uploads: true,
            file_picker_types: 'image',

            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var formData = new FormData();
                    formData.append('file', file);

                    fetch('/admin/article/upload-image', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            cb(data.location); // Masukkan URL gambar ke dalam editor
                        })
                        .catch(error => console.error('Error:', error));
                };
                input.click();
            },

            setup: function(editor) {
                editor.on('BeforeSetContent', function(e) {
                    if (e.content === '') {
                        let images = editor.getBody().querySelectorAll('img');
                        images.forEach(img => {
                            let imageUrl = img.getAttribute('src');
                            fetch('/admin/article/delete-image', {
                                    method: 'POST',
                                    body: JSON.stringify({
                                        image_url: imageUrl
                                    }),
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => console.log(data.message))
                                .catch(error => console.error('Error:', error));
                        });
                    }
                });
            }

        });
    </script>
@endsection
