@extends('layouts.template')

@section('content')
    <style>
        .profile-image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-user-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item b {
            font-weight: 500;
        }

        .list-group-item a {
            font-weight: 400;
            color: black;
            pointer-events: none;
        }

        #upload_foto {
            margin-top: 10px;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <form action="{{ route('upload.foto') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="profile-image-container">
                                <img class="profile-user-img img-fluid img-circle"
                                    @if (file_exists(public_path('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.png')))
                                        src="{{ asset('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.png') }}"
                                    @elseif (file_exists(public_path('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.jpg')))
                                        src="{{ asset('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.jpg') }}"
                                    @elseif (file_exists(public_path('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.jpeg')))
                                        src="{{ asset('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.jpeg') }}"
                                    @else
                                        src="{{ asset('path/to/default/image.jpg') }}"
                                    @endif
                                    alt="User profile picture">
                                
                                <input type="file" id="upload_foto" name="foto" accept="image/*" class="mt-2">
                            </div>
                            <h3 class="profile-username text-center mt-3">{{ auth()->user()->nama }}</h3>
                            <p class="text-muted text-center">{{ auth()->user()->level->level_nama }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Username</b>
                                    <a>{{ auth()->user()->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Nama</b>
                                    <a>{{ auth()->user()->nama }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tingkat Level</b>
                                    <a>{{ auth()->user()->level->level_nama }}</a>
                                </li>
                            </ul>
                            
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection