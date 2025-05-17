@extends('admin_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">User</h3>

                    <div class="card-tools d-flex align-items-center ml-auto">

                        <form method="GET" action="{{ url('/admin/master/user') }}" class="d-flex align-items-center">

                            <div class="input-group input-group-sm" style="width: 80px; margin-right: 10px;">
                                <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                    <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm" style="width: 150px; margin-right: 10px;">
                                <input type="text" name="table_search" class="form-control" placeholder="Search"
                                    value="{{ request('table_search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUser">Add
                            User</button>
                    </div>
                </div>


                <div class="card-body " style="border-top: 1px solid #dee2e6;  overflow: hidden;">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 " style="width: 100%; table-layout: fixed; ">
                            <thead style="background-color: #578FCA; color: white;">
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th style="width: 300px">Name</th>
                                    <th style="width: 100px">Foto Profil</th>
                                    <th style="width: 250px">email</th>
                                    <th style="width: 120px">role</th>
                                    <th style="width: 200px">No Hp</th>
                                    <th style="width: 200px">Tanggal lahir</th>
                                    <th style="width: 200px">Tanggal masuk</th>
                                    <th style="width: 400px">Alamt</th>
                                    <th style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($user) == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endif
                                @foreach ($user as $key => $item)
                                    <tr>
                                        <td style="max-width: 50px"> {{ $key + 1 }} </td>
                                        <td style="max-width: 300px"> {{ $item->name }} </td>
                                        <td style="max-width: 100px">
                                            @if ($item->foto_profil)
                                                <img src="{{ Storage::url($item->foto_profil) }}" alt=""
                                                    style="width: 80px;height:80px;object-fit: cover;object-position: center; border-radius: 50%">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="max-width: 250px"> {{ $item->email }} </td>
                                        <td style="max-width: 100px"> {{ $item->role }} </td>
                                        <td style="max-width: 200px"> {{ $item->no_hp }} </td>
                                        <td style="max-width: 200px"> {{ $item->tanggal_lahir }} </td>
                                        <td style="max-width: 200px"> {{ $item->tanggal_masuk }} </td>
                                        <td style="max-width: 400px"> {{ $item->alamat }} </td>
                                        <td>
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ url('/admin/master/user/delete/' . $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $item->id }}"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                            <a class="btn btn-warning btn-edit btn-sm" data-toggle="modal"
                                                data-target="#editUser" data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}" data-role="{{ $item->role }}"
                                                data-email="{{ $item->email }}" data-no_hp="{{ $item->no_hp }}"
                                                data-tanggal_lahir="{{ $item->tanggal_lahir }}"
                                                data-alamat="{{ $item->alamat }}">
                                                <i class="fa-solid fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto m-2">
                        <p>Showing {{ $user->firstItem() }} to {{ $user->lastItem() }} of {{ $user->total() }} entries
                        </p>
                    </div>
                    <div class="col-auto m-2">
                        {{ $user->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>



    @include('admin_page.user.addUserModal')
    @include('admin_page.user.editUserModal')
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

        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let role = $(this).data('role');
                let no_hp = $(this).data('no_hp');
                let tanggal_lahir = $(this).data('tanggal_lahir');
                let alamat = $(this).data('alamat');

                $('#editUser').find('form').attr('action', '/admin/master/user/edit/' + id);

                $('#editUser').find('input[name="id"]').val(id);
                $('#editUser').find('input[name="name"]').val(name);
                $('#editUser').find('input[name="email"]').val(email);
                $('#editUser').find('select[name="role"]').val(role);
                $('#editUser').find('input[name="no_hp"]').val(no_hp);
                $('#editUser').find('input[name="tanggal_lahir"]').val(tanggal_lahir);
                $('#editUser').find('textarea[name="alamat"]').val(alamat);


            })
            $('editUser').modal('show');
        })


        function togglePassword(event, inputId = 'password', iconId = 'togglePasswordIcon') {
            event.preventDefault();
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (!passwordInput || !toggleIcon) return;

            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        }
    </script>
@endsection
