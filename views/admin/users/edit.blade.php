@extends('admin.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
    <h1 class="h2">{{ $title }}</h1>

    @include('admin.components.display-msg-success')
    @include('admin.components.display-msg-fail')
    @include('admin.components.display-errors')

    <div class="row">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="card">
                <a href="/admin/users/create" class="btn btn-sm btn-success">Create</a>
                <div class="card-body">
                    <div class="container">
                        <form action="/admin/users/update/{{ $user['id']}}" method="POST" enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label for="name" class="col-4 col-form-label">Name</label>
                                <div class="col-8">
                                    <input type="text" name="name" id="name" class="form-control"
                                      value="{{ $user['name'] }}"  />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-4 col-form-label">Email</label>
                                <div class="col-8">
                                    <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user['email'] }}" />
                                </div>
                            </div>
                            {{-- <div class="mb-3 row">
                                <label for="password" class="col-4 col-form-label">Password</label>
                                <div class="col-8">
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="confirm_password" class="col-4 col-form-label">Confirm Password</label>
                                <div class="col-8">
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control">
                                </div>
                            </div> --}}
                            <div class="mb-3 row">
                                <label for="avatar" class="col-4 col-form-label">Avatar</label>
                                <div class="col-8">
                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                    <img src="{{ file_url($user['avatar']) }}" width="100px" alt="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="type" class="col-4 col-form-label">Type</label>
                                <div class="col-8">
                                    <select name="type" id="type" class="form-select">
                                        <option value="admin" @selected($user['type'] == 'admin')>Admin</option>
                                        <option value="client" @selected($user['type'] == 'client')>Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="offset-sm-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                    <a href="/admin/users" class="btn btn-warning">
                                        Back to list
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
