@extends('website.layouts.app')

@section('main-content')
    <!-- start page-title -->
    <section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->campaign_banner_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1><span class="title-custom-color">@lang('messages.Our')</span> @lang('messages.Campaigns')</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                    <li class="active">@lang('messages.Our Campaigns')</li>
                </ol>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start popular-campaign -->
    <section class="popular-campaign section-padding" id="popular-campaign">
        <div class="container">
            <div class="row content" id="lightgallery">
                @include('website.about.campaign_data')
            </div>
        </div> <!-- end container -->
        <div id="last-count">
            <input type='hidden' id='detectLastPage' value='0'>
        </div>
        <div class="ajax-load text-center" style="display:none">
            <p><img src="{{asset('site-assets/images/loading.gif')}}"></p>
        </div>
    </section>
    <!-- end popular-campaign -->

@endsection

@push('scripts')
<script>
    /*new way try start*/
    galleryList();
    function galleryList() {
        var page = 1;
        var checkLastPage = $('#detectLastPage').val();
        $(window).scroll(function () {
            var checkLastPage = $('#detectLastPage').val();
            if (checkLastPage !== '1') {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 600) {
                    page++;
                    loadMoreData(page);
                }
            }
        });
    }

    function loadMoreData(page) {
        $.ajax(
            {

                url: '?page=' + page,
                type: "get",
                beforeSend: function () {
                    $('.ajax-load').show();

                }
            })
            .done(function (data) {
                if (data.html == "") {
                    $('#detectLastPage').val('1');
                }
                $('.ajax-load').hide();
                $("#lightgallery").append(data.html);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                //alert('server not responding...');
            });
    }




</script>

@endpush