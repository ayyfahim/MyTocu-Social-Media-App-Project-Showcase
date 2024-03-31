@extends('layouts.dashboard')

@section('frontend.terms')
class="active"
@endsection

@section('styles')
@trixassets
<style>
    trix-editor {
        min-height: 35em;
    }
</style>
@endsection

@section('content')
<div class="row" id="basic-table">
    <div class="col-4">
        <a href="{{ route('admin.terms-of-use.index') }}" class="btn btn-success mb-3">View All</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Terms</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('admin.terms-of-use.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <div class="form-group">
                                        <label for="term_title">Term Title</label>
                                        <input type="text" id="term_title" class="form-control" name="term_title"
                                            value="{{ old('term_title') }}">
                                    </div>
                                    @trix(\App\Frontend\TermsOfUse::class, 'description')
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
