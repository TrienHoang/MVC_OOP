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

    <div class="row">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="card">
                <a href="/admin/categories/create" class="btn btn-sm btn-success">Create</a>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $category)
                                    <tr>
                                        <td scope="row">{{ $category['id'] }}</td>
                                        <td>{{ $category['name'] }}</td>
                                        <td>
                                            <img src="{{file_url($category['img'])}}" alt="image" width="100px">
                                        </td>
                                        <td>
                                            @if ($category['is_active'])
                                                <span class="badge bg-info">YES</span>
                                            @else
                                                <span class="badge bg-danger">NO</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/admin/categories/show/{{ $category['id'] }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="/admin/categories/edit/{{ $category['id'] }}" class="btn btn-sm btn-warning">Update</a>
                                            <a href="/admin/categories/delete/{{ $category['id'] }}" class="btn btn-sm btn-danger" 
                                            onclick=" return confirm('Bạn có chắc muốn xóa?')">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
