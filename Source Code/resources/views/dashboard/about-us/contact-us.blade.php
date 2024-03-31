@extends('layouts.dashboard')

@section('frontend.contact')
class="active"
@endsection

@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Contact Us</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{route('admin.contact_us_post')}}">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="header">Header</label>
                                        <input type="text" id="header" class="form-control" name="header"
                                            value="{{ $contact_us->header }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tagline">Tagline</label>
                                        <input type="text" id="tagline" class="form-control" name="header_description"
                                            value="{{ $contact_us->header_description }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="office-address">Office Address</label>
                                        <input type="text" id="office-address" class="form-control"
                                            name="office_address" value="{{ $contact_us->office_address }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" class="form-control" name="phone_number"
                                            value="{{ $contact_us->phone_number }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="text" id="email" class="form-control" name="email_address"
                                            value="{{ $contact_us->email_address }}">
                                    </div>
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
