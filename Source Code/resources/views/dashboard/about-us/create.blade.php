@extends('layouts.dashboard')

@section('styles')
@trixassets
<style>
    trix-editor {
        min-height: 35em;
    }
</style>
@endsection

@section('frontend.about')
class="active"
@endsection

@section('content')
<div class="row">
    <div class="col-4">
        <a href="{{ route('admin.about-us.index') }}" class="btn btn-success mb-3">View All</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">About Us</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('admin.about-us.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <div class="form-group">
                                        <label for="about_name">About Name</label>
                                        <input type="text" id="about_name" class="form-control" name="about_name"
                                            value="{{ old('about_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="about_title">About Title</label>
                                        <input type="text" id="about_title" class="form-control" name="about_title"
                                            value="{{ old('about_title') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="background_image">Background Image</label>
                                        <input type="file" id="background_image" class="form-control"
                                            name="background_image">
                                        <small>1920x600 recommended</small>
                                    </div>
                                    @trix(\App\Frontend\AboutUs::class, 'description')
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
