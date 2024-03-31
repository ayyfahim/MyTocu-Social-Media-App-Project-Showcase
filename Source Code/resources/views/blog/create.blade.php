@extends('layouts.dashboard')

@section('styles')
@trixassets
<style>
    trix-editor {
        min-height: 35em;
    }

</style>
@endsection

@section('blog.create')
class="active"
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Blog</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('blog.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <div class="form-group">
                                        <label for="blog_title">Blog Title</label>
                                        <input type="text" id="blog_title" class="form-control" name="blog_title"
                                            value="{{ old('blog_title') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_image">Blog Image</label>
                                        <input type="file" id="blog_image" class="form-control" name="blog_image">
                                        <small>750x430 recommended</small>
                                    </div>
                                    @trix(\App\Blog::class, 'description')
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
