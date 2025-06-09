@extends('user_page.layout')

@section('style')
    <style>
        .btn-delete:hover {
            cursor: pointer;
            scale: 1.2;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'teacher')
                                <a href="{{ url('/admin/article') }}" class="btn btn-secondary btn-back mx-2">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            @elseif (Auth::user()->role == 'user')
                                <a href="{{ url('/user/materi/' . $materi->id) }}" class="btn btn-secondary btn-back mx-2">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            @endif
                            <div class="materi-info">
                                <h3 class="materi-title">Discustion About {{ $materi->judul }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class=" card-widget mt-0">
                            <div class="card-footer card-comments">
                                @foreach ($comments as $item)
                                    <div class="card-comment">
                                        <img class="img-circle img-sm " src="{{ Storage::url($item->user->foto_profil) }}"
                                            alt="User Image" >

                                        <div class="comment-text">
                                            <span class="username">
                                                {{ $item->user->name }}
                                                @if ($item->user->role == 'superadmin' || $item->user->role == 'teacher')
                                                    <span class="badge px-2 py-1"
                                                        style="background-color: gold;color:rgb(255, 255, 255);border-radius:50px">T</span>
                                                @else
                                                    <span class="badge px-2 py-1"
                                                        style="background-color: {{ $item->user->levels->first()->warna ?? '#000' }} ;color:rgb(255, 255, 255);border-radius:50px">
                                                        {{ $item->user->levels->first()->urutan_level ?? '' }} </span>
                                                @endif
                                                @if (Auth::user()->id === $item->user->id)
                                                    <form id="delete-form-{{ $item->id }}" method="POST"
                                                        style="display:inline;"
                                                        action="{{ url('/user/materi/delete-comment/' . $item->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="float-right btn-delete"
                                                            style="color: red; background-color: transparent; border: none;"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </span><!-- /.username -->
                                            <p>{{ $item->comment }}</p>
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>
                                @endforeach
                                <!-- /.card-comment -->
                            </div>
                            <!-- /.card-footer -->
                            <div class="card-footer">
                                <form action="{{ url('user/materi/comment_store') }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <img class="img-fluid img-circle img-sm"
                                        src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Alt Text">
                                    <div class="input-group">
                                        <input type="text" name="comment" placeholder="Type Message ..."
                                            class="form-control">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa-solid fa-paper-plane"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(function(button) {
                button.addEventListener('click', function() {
                    let formId = button.getAttribute('data-id');

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + formId).submit();
                        }
                    })
                })
            })
        })
    </script>
@endsection
