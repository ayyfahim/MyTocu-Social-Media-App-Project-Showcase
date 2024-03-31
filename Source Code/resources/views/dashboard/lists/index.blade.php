@extends('layouts.dashboard')

@section('list.index')
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
                    <th>NAME</th>
                    <th>N. of Posts</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $list)
                <tr>
                    <td></td>
                    <td class="product-name">{{ $list->user->name }}</td>
                    <td class="product-name">{{ $list->title }}</td>
                    <td class="product-category">{{ $list->posts->count() }}</td>
                    <td class="product-action">
                        <div class="chip chip-info">
                            <div class="chip-body">
                                <div class="chip-text"><a href="{{ route('list.show', $list->slug) }}"
                                        class="text-white">View</a></div>
                            </div>
                        </div>
                        @can('manage-contents')
                        <div class="chip chip-success">
                            <div class="chip-body">
                                <div class="chip-text"><a href="{{ route('list.edit', $list->slug) }}"
                                        class="text-white">Edit</a></div>
                            </div>
                        </div>
                        <div class="chip chip-danger">
                            <div class="chip-body">
                                <div class="chip-text">
                                    <a href="{{ route('list.destroy', $list->slug) }}"
                                        class="text-white bg-transparent border-0">Delete</a>
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
