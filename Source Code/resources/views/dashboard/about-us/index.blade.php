@extends('layouts.dashboard')

@section('frontend.about')
class="active"
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">About Us</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <!-- Table with outer spacing -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($about_us as $row)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{$row->name}}</td>
                                    <td>
                                        <a class="btn btn-success waves-effect waves-light"
                                            href="{{ route('admin.about-us.edit', $row->id) }}">Edit</a>
                                        @if ($row->status == 0)
                                        <a class="btn btn-success waves-effect waves-light"
                                            href="{{ route('admin.about-us.activate', $row->id) }}">Activate</a>
                                        @endif
                                        <form action="{{ route('admin.about-us.destroy', $row->id) }}" method="post"
                                            class="d-inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger waves-effect waves-light">Delete</button>
                                        </form>
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
</div>
@endsection
