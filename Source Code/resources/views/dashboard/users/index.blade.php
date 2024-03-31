@extends('layouts.dashboard')

@section('users.list')
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
                    <th>Image</th>
                    <th>NAME</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td></td>
                    <td class="product-img">
                        <img src="{{ route('image.account', $user->user_image) }}" alt="{{ $user->name }}">
                    </td>
                    <td class="product-name">{{ $user->name }}</td>
                    <td class="product-category">{{ implode(', ',$user->roles()->get()->pluck('name')->toArray()) }}
                    </td>
                    <td>
                        <div class="chip chip-{{ (!$user->deleted_at) ? 'info' : 'danger' }}">
                            <div class="chip-body">
                                <div class="chip-text">{{ (!$user->deleted_at) ? 'Active' : 'Disabled' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="product-action">
                        <div class="chip chip-info">
                            <div class="chip-body">
                                <div class="chip-text"><a href="{{ route('admin.users.show', $user->slug) }}"
                                        class="text-white">View</a></div>
                            </div>
                        </div>
                        @can('edit-users')
                        <div class="chip chip-success">
                            <div class="chip-body">
                                <div class="chip-text"><a href="{{ route('admin.users.edit', $user->slug) }}"
                                        class="text-white">Edit</a></div>
                            </div>
                        </div>
                        @endcan
                        @can('delete-users')
                        <div class="chip chip-danger">
                            <div class="chip-body">
                                <div class="chip-text">
                                    <form action="{{ route('admin.users.destroy', $user->slug) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="text-white bg-transparent border-0">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </td>
                </tr>
                @empty

                @endforelse
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
