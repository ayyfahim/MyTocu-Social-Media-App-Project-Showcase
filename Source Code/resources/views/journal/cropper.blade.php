@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css"
    integrity="sha256-/n6IXDwJAYIh7aLVfRBdduQfdrab96XZR+YjG42V398=" crossorigin="anonymous" />
@endsection
@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3" style="max-width: 100%;">
            <div class="card-header">
                <a href="#" class="custom float-left"><i class="fas fa-chevron-left"></i></a>
                <h5 class="text-center m-0">Crop Image</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="upload-image"></div>
                        <img src="{{ route('image.journal', ['filename' => $journal->journal_image]) }} " alt=""
                            class="img-fluid d-none" id="cropbox">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="preview crop_preview">
            <div id="upload-image-i"></div>
            {{-- <img src="#" alt="" class="img-fluid" id="cropped_img" style="display: none;"> --}}
        </div>
    </div>
    <div class="col-md-3">
        <button class="btn btn-success" id="crop">Crop</button>
        <a href="{{ route('view.account') }}" class="btn btn-danger">Cancel/Back</a>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"
    integrity="sha256-bQTfUf1lSu0N421HV2ITHiSjpZ6/5aS6mUNlojIGGWg=" crossorigin="anonymous"></script>
<script type="text/javascript">
    var imgsrc = document.getElementById("cropbox").src;
    $image_crop = $('#upload-image').croppie({
        enableExif: true,
        viewport: {
            width: 300,
            height: 300,
            type: 'square'
        },
        boundary: {
            width: "100%",
            height: 300
        }
    });

    $image_crop.croppie('bind', {
        url: imgsrc
    }).then(function () {
        console.log('jQuery bind complete');
    });

    $('#crop').on('click', function (ev) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $.ajax({
                url: "{{route('crop.image.journal')}}",
                type: "POST",
                data: {
                    "_token": '{{ Session::token() }}',
                    "journal_image": response,
                    "journal_id": {{$journal->id}},
                },
                success: function (data) {
                    html = '<img src="' + response + '" />';
                    $("#upload-image-i").html(html);
                }
            });
        });
    });
</script>
@endsection