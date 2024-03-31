@extends('layouts.dashboard')

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="chartjs-charts">

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-2">
                    <h4 class="card-title">Total Users: {{ \App\User::all()->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-2">
                    <h4 class="card-title">Total Lists: {{ \App\Liste::all()->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-2">
                    <h4 class="card-title">Total Journals: {{ \App\Journal::all()->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Line Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lists Today:
                        {{ \App\Liste::whereDate('created_at', \Carbon\Carbon::now()->format('Y-m-d'))->count() }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body ">
                        {{ $list_today->container() }}
                        {{ $list_today->script() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Journals Today:
                        {{ \App\Journal::whereDate('created_at', \Carbon\Carbon::now()->format('Y-m-d'))->count() }}
                    </h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        {{ $journal_today->container() }}
                        {{ $journal_today->script() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lists in Last 7 days</h4>
                </div>
                <div class="card-content">
                    <div class="card-body ">
                        {{ $list_7_days->container() }}
                        {{ $list_7_days->script() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Journals in Last 7 days</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        {{ $journal_7_days->container() }}
                        {{ $journal_7_days->script() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Analytics end -->
@endsection
