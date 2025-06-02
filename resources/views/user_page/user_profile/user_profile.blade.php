@extends('user_page.layout')
@section('style')
    <style>
        .profile-image-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .edit-icon {
            position: absolute;
            right: 5px;
            bottom: 5px;
            background-color: #17a2b8;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .form-control {
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            height: calc(2.25rem + 2px);
        }

        .form-control.address {
            height: 100px;
        }

        .btn-batal {
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            width: 100%;
        }

        .btn-simpan {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="profile-container m-3">
        <!-- Profile Form -->
        <form action="{{ url('user/profile/'. $userActive->id) }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')
            
            <div class="profile-image-container">
                <div class="profile-image"
                    style="background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                    <img id="profileImagePreview" src="{{ Auth::user()->foto_profil && Storage::exists(Auth::user()->foto_profil) ? Storage::url(Auth::user()->foto_profil) : asset('image/Avatar.png') }}"
                        alt="Profile Image" class="img-fluid"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <div class="edit-icon" onclick="document.getElementById('profileImageUpload').click();">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <input type="file" name="foto_profil" id="profileImageUpload" style="display: none;" accept="image/*" onchange="previewProfileImage(this);">
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="changeName" value="{{ $userActive->name }}"
                        name="name" />
                </div>
                <div class="form-group col-6">
                    <label for="">No hp</label>
                    <input type="tel" class="form-control" name="no_hp" pattern="[0-9]+" inputmode="numeric"
                        value="{{ $userActive->no_hp }}" name="no_hp" />
                </div>
                <div class="form-group col-6">
                    <label for="">Email</label>
                    <input type="email" class="form-control" id="changeEmail" value="{{ $userActive->email }}" readonly>
                </div>
                <div class="form-group col-6">
                    <label for="">Password</label>
                    <input type="password" class="form-control" placeholder="Change Password" id="changePassword"
                        name="password">
                </div>
                <div class="form-group col-6">
                    <label for="">Date of Birth</label>
                    <input type="date" class="form-control" id="changePassword" name="tanggal_lahir" value="{{ $userActive->tanggal_lahir }}"
                        name="tanggal_lahir">
                </div>
                <div class="form-group col-6">
                    <label for="">Date of Join</label>
                    <input type="date" class="form-control" id="changePassword" value="{{ $userActive->tanggal_masuk }}"
                        readonly>
                </div>
                <div class="form-group col-12">
                    <label for="">Address</label>
                    <textarea class="form-control address" id="changeAddress" name="alamat"> {{ $userActive->alamat }} </textarea>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <div class="row">
                        <button type="button" class="btn btn-batal col-5 mx-1" onclick="resetForm()">BATAL</button>
                        <button type="submit" class="btn btn-simpan col-5 mx-1">SIMPAN</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewProfileImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetForm() {
            document.getElementById('profileForm').reset();
            // Reset the image preview to the original image
            document.getElementById('profileImagePreview').src = "{{ Auth::user()->foto_profil && Storage::exists(Auth::user()->foto_profil) ? Storage::url(Auth::user()->foto_profil) : asset('image/Avatar.png') }}";
        }
    </script>
@endsection
