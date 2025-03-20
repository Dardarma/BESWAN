@extends('admin_page.layout')
@section('content')

        <div class="row mx-2">
            <div class="col-12">
                
                <h1>Edit User</h1>

                <div class="card card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-1 m-0 p-0 text-end">
                                <a href="{{ url('master/user')}}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
                            </div>  
                            <div class="col-6 m-0 p-0">
                                <h2>Edit User</h2>
                            </div>                     
                        </div>
                    </div>
                    <!-- form start -->
                    <div class="card-body">
                        <form method="POST" action="{{ url('master/user/edit/'.$user->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div class="form-group">
                                <label for="name">Nama:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password (Kosongkan jika tidak ingin diubah):</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <!-- Role -->
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Student</option>
                                </select>
                            </div>

                            <!-- Nomor HP -->
                            <div class="form-group">
                                <label for="no_hp">Nomor HP:</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}">
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group">
                                <label for="alamat">Alamat:</label>
                                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                            

                            <!-- Tanggal Lahir -->
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir:</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
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
