@extends('layouts.dashboard')

@section('frontend.terms')
class="active"
@endsection

@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Terms of Use</h4>
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
                                @foreach ($terms as $term)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $term->term_header }}</td>
                                    <td>
                                        <a class="btn btn-success waves-effect waves-light"
                                            href="{{ route('admin.terms-of-use.edit', $term->id) }}">Edit</a>
                                        <form action="{{ route('admin.terms-of-use.destroy', $term->id) }}"
                                            method="post" class="d-inline-block">
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
