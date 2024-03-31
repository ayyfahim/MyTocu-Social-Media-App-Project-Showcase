@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/style.css') }}">
<style>
    body {
        position: unset;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Roboto", sans-serif;
        letter-spacing: normal;
    }

    .like-amount {
        font-weight: 800;
        margin: 10px 0;
        display: block;
    }

    ul.nav-tabs.nav--tabs2 li a {
        border: none;
        text-transform: uppercase;
        /* padding: 1rem 0; */
        color: #8e8e8e;
        font-weight: 500;
        font-size: 13px;
        letter-spacing: 1.2px;
        font-family: "Roboto", sans-serif;
        z-index: 1;
        text-align: center;
    }

    ul.nav-tabs.nav--tabs2 li a.active {
        color: #000000;
    }
</style>
@endsection

@section('content-fluid')

<section class="py-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shortcode_module_title">
                    <div class="dashboard__title">
                        <h3>Explore</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row lower-part">
            <div class="col-md-12">
                <div class="shortcode_modules">
                    <div class="tab tab3">
                        <div class="item-navigation">
                            <ul class="nav nav-tabs nav--tabs2">
                                <li>
                                    <a href="#lists" class="active" aria-controls="lists" role="tab" data-toggle="tab">
                                        <i class="fas fa-th"></i> Lists
                                    </a>
                                </li>
                                <li>
                                    <a href="#journals" aria-controls="journals" role="tab" data-toggle="tab">
                                        <i class="fas fa-book"></i> Journals
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- end /.item-navigation -->

                        <div class="tab-content">
                            <div class="tab-pane product-tab fade show active" id="lists">
                                <div class="row contents">
                                    @forelse ($lists as $list)

                                    @include('list.block')

                                    @empty
                                    <div class="col-md-12 align-self-center">
                                        <p class="empty"><i class="far fa-frown"></i> No users have posted.</p>
                                    </div>
                                    @endforelse
                                    <div class="col-md-12">
                                        {{ $lists->links() }}
                                    </div>
                                </div>
                            </div>
                            <!-- end /.tab-content -->

                            <div class="tab-pane product-tab fade" id="journals">
                                <div class="row journal-row contents">
                                    @forelse ($journals as $journal)

                                    @include('journal.block')

                                    @empty
                                    <div class="col-md-12 align-self-center">
                                        <p class="empty"><i class="far fa-frown"></i> No users have posted.</p>
                                    </div>
                                    @endforelse
                                    <div class="col-md-12">
                                        {{ $journals->links() }}
                                    </div>
                                </div>
                            </div>
                            <!-- end /.product-comment -->
                        </div>
                        <!-- end /.tab-content -->
                    </div>
                </div>
            </div>
            <!-- end .col-md-6 -->
        </div>
    </div>
</section>
<!-- end .row -->
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('body').on('click', '.pagination a', function (e) {

            var element = this;
            var contents = $(element).closest(".contents");

            e.preventDefault();
            var url = $(this).attr('href');

            {{--
            $.get(url, function (data) {
                contents.html(data);
            });
            --}}

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{Session::token()}}"
                },
                url: url,
                beforeSend: function() {
                    $('#wait').show()
                },
                complete: function() {
                    $('#wait').hide()
                },
                method: "get",
                success: function (data) {
                    contents.html(data);
                }
            });

        });
    });
</script>
@auth
<script src="{{ asset('js/account.js') }}"></script>
<script>
    var urlLike = "{{ route('like.store')}} ";
    var token = "{{ csrf_token() }}";
</script>
@endauth
<script src="{{ asset('js/third-party/main.js') }}"></script>
@endsection