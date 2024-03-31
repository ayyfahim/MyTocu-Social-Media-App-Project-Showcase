@extends('layouts.dashboard')

@section('content')
<div class="row" id="basic-table">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Featured Images</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <!-- Table with outer spacing -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($featured_images as $row)
                                <tr>
                                    <th scope="row">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td>
                                        <img src="{{asset('images/about_us/featured_images'.'/'.$row->featured_image)}}"
                                            alt="{{ $row->featured_image }}" class="img-fluid">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.featured_image_delete', $row->id) }}"
                                            class="btn btn-danger waves-effect waves-light">Delete</a>
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
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Featured Images</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('admin.featured_image_post') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="featured_image">Featured Image</label>
                                        <input type="file" id="featured_image" class="form-control"
                                            name="featured_image[]" value="{{ old('featured_image') }}" multiple>
                                        <p>
                                            <small class="text-muted">150x(50-100) (Recommended)</small>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
