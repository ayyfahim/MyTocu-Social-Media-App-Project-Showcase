@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css"
    integrity="sha256-/n6IXDwJAYIh7aLVfRBdduQfdrab96XZR+YjG42V398=" crossorigin="anonymous" />
@endsection

@section('content-fluid')
<section class="py-100">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-3">
                <ul id="edit_nav" class="nav flex-column" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active custom" href="#edit-profile" data-toggle="tab">Edit
                            Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="#change-password" data-toggle="tab">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="#change-email" data-toggle="tab">Change Email</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            href="{{ route('logout') }}" data-toggle="tab">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>

            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="edit-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3 align-items-center mb-4">
                                <div class="user-img" style="width: 50px; height: 50px; border-width: 1px;">
                                    <img class="current-user-image img-fluid"
                                        src="{{ route('image.account', ['filename' => $user->user_image]) }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="user-info">
                                    <h5 class="m-0">{{ $user->name }}</h5>
                                    <a href="#" data-toggle="modal" data-target="#pic_upload">Change Profile Photo</a>
                                </div>
                            </div>
                        </div>
                        <form class="custom" id="edit-account" method="POST"
                            action="{{route('user.update', auth()->user()->slug)}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" class="m-0">Name</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter your name." value="{{$user->name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="m-0">Birth Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group multiple-select">
                                        <select class="form-control" name="birth_day" id="birth_day">
                                            <option>Day</option>
                                            {{-- See helpers.php for days, months, year function --}}
                                            @foreach (days() as $day)
                                            @if ($day==$user->birthDay())
                                            <option selected value="{{$day}}">
                                                {{$day}}
                                            </option>
                                            @else
                                            <option value="{{$day}}">{{$day}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="birth_month" id="birth_month">
                                            <option>Month</option>
                                            @foreach (months() as $number => $month)
                                            @if ($number==$user->birthMonth())
                                            <option selected value="{{$number}}">{{$month}}</option>
                                            @else
                                            <option value="{{$number}}">{{$month}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="birth_year" id="birth_year">
                                            <option>Year</option>
                                            @foreach (years() as $year)
                                            @if ($year==$user->birthYear())
                                            <option selected value="{{$year}}">
                                                {{$year}}
                                            </option>
                                            @else
                                            <option value="{{$year}}">{{$year}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="gender" class="m-0">Gender</label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" {{ $user->gender=='male'?'checked':'' }} id="male"
                                            value="male" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="male">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" {{ $user->gender=='female'?'checked':'' }} id="female"
                                            value="female" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="female">Female</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" {{ $user->gender=='other'?'checked':'' }} id="other"
                                            value="other" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="other">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="m-0">Select where you live...</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group multiple-select" style="column-count: 2;">
                                        <select name="country" class="form-control dynamic" id="country"
                                            data-dependent="state">
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $user->country->id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="state" class="form-control" id="state">
                                            <option value="{{ $user->state->id ?? '' }}">
                                                {{ $user->state->name ?? 'Select State' }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="m-0">Set your profile privacy:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group multiple-select">
                                        <select name="status" class="form-control" id="status">
                                            <option value="0" {{ $user->status == 0 ? 'selected' : ''}}>Public</option>
                                            <option value="1" {{ $user->status == 1 ? 'selected' : ''}}>Private</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="email_notification" class="m-0">Email Notification</label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" {{ $user->e_notif=='1'?'checked':'' }}
                                            id="email_notification_on" value="1" name="email_notification"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="email_notification_on">On</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" {{ $user->e_notif=='0'?'checked':'' }}
                                            id="email_notification_off" value="0" name="email_notification"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="email_notification_off">Off</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info mb-4">Submit</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="#" id="disable-account" data-toggle="modal"
                                        data-target="#disableAccount">Temporary
                                        disable your account.</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="change-password" role="tabpanel">
                        <form class="custom" id="edit-account" method="POST"
                            action="{{route('user.update.password', auth()->user()->slug)}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="old_password" class="m-0">Old Password</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" name="old_password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            id="old_password" placeholder="Enter your old password.">
                                        @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="new_password" class="m-0">New Password</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" name="new_password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new_password" placeholder="Enter your new password.">
                                        @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="new_password_confirmation" class="m-0">Confirm New Password</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" name="new_password_confirmation"
                                            class="form-control @error('new_password_confirmation')is-invalid @enderror"
                                            id="new_password_confirmation" placeholder="Enter your new password again.">
                                        @error('new_password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Change Password</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="change-email" role="tabpanel">
                        <form class="custom" id="edit-account" method="POST"
                            action="{{route('user.update.email', auth()->user()->slug)}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="m-0">Current Email</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Enter your old password."
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="new_email" class="m-0">New Email</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="new_email"
                                            class="form-control @error('new_email') is-invalid @enderror @error('email') is-invalid @enderror"
                                            id="email" placeholder="Enter your new Email.">
                                        @error('new_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Change Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="disableAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disable your account Temporarily?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                What happens if you temporarily disable your account?
                <ul class="mt-1">
                    <li>Deactivating your account can be temporary.</li>
                    <li>Your profile will be disabled, your name and photos will be removed from the site. Your account
                        will be reactivated next time you log in.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
                <a href="{{ route('user.disable', auth()->user()->slug) }}" class="btn btn-primary btn-sm">Yes, I'm
                    sure.</a>
            </div>
        </div>
    </div>
</div>

<div id="pic_upload" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change profile photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="controls-stacked my-0">
                    <label class="file w-100">
                        <input class="form-control-file" type="file" id="upload_image" name="upload_image"
                            aria-label="File browser example">
                        <span class="file-custom"></span>
                    </label>
                </div>

                <img src="{{ route('image.account', ['filename' => $user->user_image]) }}" id="current_photo" alt=""
                    class="img-fluid shadow_img my-4 mx-auto">
                <div id="image_demo" style="width:100%; display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="crop_image btn btn-primary" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"
    integrity="sha256-bQTfUf1lSu0N421HV2ITHiSjpZ6/5aS6mUNlojIGGWg=" crossorigin="anonymous"></script>
<script>
    $('.dynamic').change(function () {
        if ($(this).val() != '') {
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get.state') }}",
                method: "POST",
                data: {
                    select: select,
                    value: value,
                    _token: _token,
                    dependent: dependent
                },
                success: function (result) {
                    $('#' + dependent).html(result);
                }

            })
        }
    });

    $('#country').change(function () {
        $('#state').val('');
        $('#city').val('');
    });

    $('#state').change(function () {
        $('#city').val('');
    });

</script>
<script>
    $(document).ready(function () {

        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 300,
                height: 300,
                type: 'square' //circle
            },
            boundary: {
                width: "100%",
                height: 500
            }
        });

        $('#upload_image').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);

            $('.file').css({
                'display': 'none',
            });

            $('#current_photo').css({
                'display': 'none',
            });

            $('#image_demo').css({
                'display': 'block',
            })

            if (!event || !event.target || !event.target.files || event.target.files.length === 0) {
                return;
            }

            const name = event.target.files[0].name;
            const lastDot = name.lastIndexOf('.');

            const fileName = name.substring(0, lastDot);
            const ext = name.substring(lastDot + 1);
            $img_ext = ext;
        });

        $('.crop_image').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('profile.pic') }}",
                    type: "POST",
                    data: {
                        _token: _token,
                        "extension": $img_ext,
                        "image": response
                    },
                    success: function (data) {
                        $('#pic_upload').modal('hide');
                        $(".current-user-image").attr({
                            "src": response
                        });
                    }
                });
            })
        });

    });

</script>
@endsection