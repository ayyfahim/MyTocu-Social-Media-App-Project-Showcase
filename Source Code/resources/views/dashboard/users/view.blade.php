@extends('layouts.dashboard')

@section('users.view')
class="active"
@endsection

@section('styles')
<link href="{{ asset('dashboard-assets/css/pages/app-user.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- page users view start -->
<section class="page-users-view">
    <div class="row">
        <!-- account start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Account</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="users-view-image">
                            <img src="{{ route('image.account', $user->user_image) }}" alt="{{ $user->name }}"
                                class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1">
                        </div>
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">Name</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">Status</td>
                                    <td>{{ (!$user->deleted_at) ? 'Active' : 'Disabled' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Role</td>
                                    <td>{{ implode(', ',$user->roles()->get()->pluck('name')->toArray()) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('admin.users.edit', $user->slug) }}" class="btn btn-primary mr-1"><i
                                    class="feather icon-edit-1"></i> Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->slug) }}" method="post"
                                class="d-inline-block">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger"><i
                                        class="feather icon-trash-2"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- account end -->
        <!-- information start -->
        <div class=" col-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-2">Information</div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="font-weight-bold">Birth Date </td>
                            <td>{{ $user->birthdate }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Gender</td>
                            <td>{{ $user->gender }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- information start -->
    </div>
</section>
<!-- page users view end -->
@endsection
