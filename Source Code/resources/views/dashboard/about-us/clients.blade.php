@extends('layouts.dashboard')

@section('content')
<div class="row" id="basic-table">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Team Members</h4>
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
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($team_members as $member)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <img src="{{asset('images/about_us/team'.'/'.$member->team_member_image)}}"
                                            alt="{{ $member->team_member_name }}" class="img-fluid" width="100">
                                    </td>
                                    <td>{{$member->team_member_name}}</td>
                                    <td>
                                        <a href="{{ route('admin.team_member_delete', $member->id) }}"
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
                <h4 class="card-title">Add Team Members</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('admin.team_member_post') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="team_member_name">Team Member Name</label>
                                        <input type="text" id="team_member_name" class="form-control"
                                            name="team_member_name" value="{{ old('team_member_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="team_member_occupation">Team Member Occupation</label>
                                        <input type="text" id="team_member_occupation" class="form-control"
                                            name="team_member_occupation" value="{{ old('team_member_occupation') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="team_member_facebook_url">Team Member Facebook URL</label>
                                        <input type="text" id="team_member_facebook_url" class="form-control"
                                            name="team_member_facebook_url"
                                            value="{{ old('team_member_facebook_url') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="team_member_twitter_url">Team Member Twitter URL</label>
                                        <input type="text" id="team_member_twitter_url" class="form-control"
                                            name="team_member_twitter_url" value="{{ old('team_member_twitter_url') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="team_member_instagram">Team Member Instagram URL</label>
                                        <input type="text" id="team_member_instagram" class="form-control"
                                            name="team_member_instagram" value="{{ old('team_member_instagram') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="team_member_image">Team Member Image</label>
                                        <input type="file" id="team_member_image" class="form-control"
                                            name="team_member_image" value="{{ old('team_member_image') }}">
                                        <p>
                                            <small class="text-muted">263x250 (Recommended)</small>
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
