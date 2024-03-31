@extends('layouts.dashboard')

@section('posts.index')
class="active"
@endsection

@section('styles')
<!-- Vendor CSS -->
<link href="{{ asset('dashboard-assets/vendors/css/tables/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}"
    rel="stylesheet">

<!-- Page Specific CSS -->
<link href="{{ asset('dashboard-assets/css/pages/data-list-view.min.css') }}" rel="stylesheet">

<style>
    .data-thumb-view-header .table-responsive .top .action-btns {
        opacity: 0;
    }

</style>
@endsection

@section('content')
<!-- Data list view starts -->
<section id="data-thumb-view" class="data-thumb-view-header">
    <!-- dataTable starts -->
    <div class="table-responsive">
        <table class="table data-thumb-view">
            <thead>
                <tr>
                    <th></th>
                    <th>User Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>List Name</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td></td>
                    <td class="product-name">{{ $post->user->name }}</td>
                    <td class="product-name">{{ $post->title }}</td>
                    <td class="product-name">{{ str_limit($post->description, 100) }}</td>
                    <td class="product-category">{{ $post->list->title }}</td>
                    <td class="product-action">
                        <div class="chip chip-info">
                            <div class="chip-body">
                                <div class="chip-text"><a href="{{ route('post.show', $post->id) }}"
                                        class="text-white">View</a></div>
                            </div>
                        </div>
                        @can('manage-contents')
                        <div class="chip chip-success">
                            <div class="chip-body">
                                <div class="chip-text"><a href="{{ route('post.edit', $post->id) }}"
                                        class="text-white">Edit</a></div>
                            </div>
                        </div>
                        <div class="chip chip-danger">
                            <div class="chip-body">
                                <div class="chip-text">
                                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="text-white bg-transparent border-0">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- dataTable ends -->
</section>
<!-- Data list view end -->
@endsection

@section('scripts')
<!-- Vendor JS -->
<script src='{{ asset('dashboard-assets/vendors/js/tables/datatable/datatables.min.js') }}'></script>
<script src='{{ asset('dashboard-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}'></script>
<script src='{{ asset('dashboard-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}'></script>
<script src='{{ asset('dashboard-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}'></script>
<script src='{{ asset('dashboard-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}'></script>

<!-- Page Specific JS -->
<script src='{{ asset('dashboard-assets/js/scripts/ui/data-list-view.js') }}'></script>
@endsection
