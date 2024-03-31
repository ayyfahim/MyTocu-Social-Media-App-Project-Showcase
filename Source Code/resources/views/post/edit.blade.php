@extends('layouts.app')

@section('title')
Edit Post: {{ $post->title }}
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
<section class="py-100">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="custom mb-5">Edit Post</h1>
        </div>
    </div>
    <div class="edit-block">
        <form id="edit-account" class="custom" role="form" method="POST"
            action="{{ route('post.update', $post->slug) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-2">
                    <h4>Title:</h4>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ $post->title }}">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h4>Description:</h4>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                            style="height: 300px;">{{ $post->description }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h4>Post Image:</h4>
                </div>
                <div class="col-md-8">
                    <div class="controls-stacked mt-0">
                        <label class="file">
                            <input class="form-control-file @error('description') is-invalid @enderror" type="file"
                                id="file" name="post_image" aria-label="File browser example">
                            <span class="file-custom"></span>
                            @error('post_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </label>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-8 cropper-wrapper mb-3">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="image-demo"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 offset-md-2">
                    <button type="submit" class="btn btn-primary" id="submit">
                        Edit Post
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
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
                // width: "100%",
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

        $('#submit').on('click', function () {
            $image_crop.croppie('result', {
                type: 'canvas',
                format: 'png',
                quality: '1',
                size: {
                    width: 500,
                    height: 500
                },
            }).then(function (response) {
                var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "cropped_image").val(response);
                $('#edit-account').append(input);
            })
        })

    });

</script>
@endsection
