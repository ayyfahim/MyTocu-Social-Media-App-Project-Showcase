@extends('layouts.dashboard')

@section('frontend.privacy')
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
        <a href="{{ route('admin.privacy-policy.index') }}" class="btn btn-success mb-3">View All</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Terms</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('admin.privacy-policy.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <div class="form-group">
                                        <label for="privacy_policy_title">Policy Title</label>
                                        <input type="text" id="privacy_policy_title" class="form-control"
                                            name="privacy_policy_title" value="{{ old('privacy_policy_title') }}">
                                    </div>
                                    @trix(\App\Frontend\PrivacyPolicy::class, 'description')
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
