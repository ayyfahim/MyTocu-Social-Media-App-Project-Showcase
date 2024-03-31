@extends('layouts.dashboard')

@section('users.edit')
class="active"
@endsection

@section('content')
<!-- users edit start -->
<section class="users-edit">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab"
                            href="#account" aria-controls="account" role="tab" aria-selected="true">
                            <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Account</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                        <!-- users edit media object start -->
                        <div class="media mb-2">
                            <a class="mr-2 my-25" href="#">
                                <img src="{{ route('image.account', $user->user_image) }}" alt="{{ $user->name }}"
                                    class="users-avatar-shadow rounded" height="90" width="90">
                            </a>
                            <div class="media-body mt-50">
                                <h4 class="media-heading">{{ $user->name }}</h4>
                                <h5 class="media-heading">{{ $user->state->name }}, {{ $user->country->name }}</h5>
                            </div>
                        </div>
                        <!-- users edit media object ends -->
                        <!-- users edit account form start -->
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Name"
                                                value="{{ $user->name }}" required
                                                data-validation-required-message="This username field is required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>E-mail</label>
                                            <input type="email" name="email" class="form-control" placeholder="Email"
                                                value="{{ $user->email }}" required
                                                data-validation-required-message="This email field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="">Gender</label>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-radio-con">
                                                        <input type="radio" name="gender"
                                                            {{ $user->gender == "male" ? 'checked' : '' }} value="male">
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                                        <span class="">Male</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-radio-con">
                                                        <input type="radio" name="gender"
                                                            {{ $user->gender == "female" ? 'checked' : '' }}
                                                            value="female">
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                                        <span class="">Female</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <div class="controls pt-1">
                                            <label for="">User Role</label>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($roles as $role)
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" value="{{ $role->id }}" name="roles[]"
                                                            {{ ($user->roles->pluck('id')->contains($role->id) ? "checked" : '') }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{ $role->name }}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit account form ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- users edit ends -->
@endsection
