@extends('layouts.app')

@section('title')
Create Journal
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css"
    integrity="sha256-/n6IXDwJAYIh7aLVfRBdduQfdrab96XZR+YjG42V398=" crossorigin="anonymous" />
<style>
    .cropper-wrapper {
        display: none;
    }
</style>
@endsection
@section('content')
<div class="row justify-content-center align-items-center py-100">
    <div class="col-md-8">
        <div class="card mb-3" style="max-width: 100%;">
            <div class="card-header">
                <a href="{{ url()->previous() }}" class="custom float-left"><i class="fas fa-chevron-left"></i></a>
                <h5 class="text-center m-0">New Journal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="user-img" style="width: 50px; height: 50px; border-width: 2px;">
                            <img src="{{ route('image.account', ['filename' => Auth::user()->user_image]) }}" alt=""
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <form role="form" method="POST" id="journal_form" class="custom"
                            action="{{ route('journal.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group has-textarea">
                                <textarea id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    style="height: 260px;">{{ old('description') }}</textarea>
                                <label for="description"><span>Write a caption...</span></label>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="controls-stacked">
                                <label class="file">
                                    <input
                                        class="form-control-file form-control @error('journal_image') is-invalid @enderror"
                                        type="file" id="file" name="journal_image" aria-label="File browser example">
                                    <span class="file-custom"></span>
                                    @error('journal_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                            </div>
                            @foreach ($errors as $error)
                            <p>{{$error}}</p>
                            @endforeach
                            {{-- <div class="alert file-upload-alert alert-dark alert-dismissible fade show  d-block"
                                role="alert">
                                <strong>Holy guacamole!</strong> You should check in on some of those fields
                                below.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary site-btn">
                                    Create Journal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 cropper-wrapper">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-sm">Crop Image</a>
                <a class="btn btn-sm text-primary crop_image float-right">Next</a>
            </div>
            <div class="image-demo"></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"
    integrity="sha256-bQTfUf1lSu0N421HV2ITHiSjpZ6/5aS6mUNlojIGGWg=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        $image_crop = $('.image-demo').croppie({
            enableExif: true,
            viewport: {
                width: 250,
                height: 250,
                type: 'square' //circle
            },
            boundary: {
                height: 500
            }
        });

        $('#file').on('change', function () {

            var file = event.target.files[0];

            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    // console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);

            $('.cropper-wrapper').css({
                'display': 'block',
            })

            $('.site-btn').css({
                'display': 'none',
            })

            if (!event || !event.target || !event.target.files || event.target.files.length === 0) {
                return;
            }

            const name = file.name;
            const lastDot = name.lastIndexOf('.');
            const fileName = name.substring(0, lastDot);
            const ext = name.substring(lastDot + 1);
            $img_ext = ext;

            window.file_name = file.name;
            $('.file-custom').addClass('uploaded').attr('data-content', file_name);
        });

        $('.crop_image').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                format: 'png',
                quality: '1',
                size: {
                    width: 500,
                    height: 500
                },
            }).then(function (response) {
                // var file = dataURLtoFile(response, file_name);
                var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "cropped_image").val(response);


                $('#journal_form').append(input);
                $('#journal_form').submit();
            })
        });

    });

</script>
<script>
    function checkForInput(element) {
        // element is passed to the function ^

        const $label = $(element);

        if ($(element).val().length > 0) {
            $label.addClass('input-has-value');
        } else {
            $label.removeClass('input-has-value');
        }
    }

    function checkForInputLabel(element) {
        // element is passed to the function ^

        const $label = $(element).siblings('label');

        if ($(element).val().length > 0) {
            $label.addClass('input-has-value');
        } else {
            $label.removeClass('input-has-value');
        }
    }

    // The lines below are executed on page load
    $('.form-control').each(function () {
        checkForInputLabel(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.form-control').on('change keyup', function () {
        checkForInputLabel(this);
    });

    // The lines below are executed on page load
    $('.form-control').each(function () {
        checkForInput(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.form-control').on('change keyup', function () {
        checkForInput(this);
    });

    $('#file').on('change', function () {
        var file = $('#file')[0].files[0].name;
        $('.file-custom').addClass('uploaded').attr('data-content', file);
    });

</script>

@endsection