@extends('website.layouts.app')

@section('main-content')
    <!-- start page-title -->
    <section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->campaign_details_banner_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1>{{ $data['date'] }}</h1>
                <p class="total-photos"><label style="background-color: #ed3237;padding: 7px;font-size: 11px;" class="label label-danger">@lang('messages.Total') : <strong>{{$data['total_photos']}}</strong> @lang('messages.photos')</label></p>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <section style="padding: 80px 0">
       <div class="container">
           <div class="row section-title-s2">
               <div class="col col-xs-12">
                   <h2 style="margin-bottom: 20px">{{$data['title']}}</h2>
               </div>
               <div class="section-title-short-brief">
                   <div class="col col-xs-12">
                       <p>{{$data['description']}}</p>
                   </div>
               </div>
           </div>
           <div class="row gallery">
               <div class="demo-gallery">
                   <ul id="lightgallery" class="list-unstyled row">
                       @include('website.about.data')
                   </ul>
               </div>
               <div id="last-count">
                   <input type='hidden' id='detectLastPage' value='0'>
               </div>
           </div>
       </div>
        <div class="ajax-load text-center" style="display:none">
            <p><img src="{{asset('site-assets/images/loading.gif')}}"></p>
        </div>
    </section>
    <!-- start newsletter -->
   {{-- <section class="newsletter">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-5 children-holder"  style="background: url({{asset($setting->home_volunteer_image)}}) center center/cover no-repeat local;"></div>
                <div class="col col-md-7 subscribe">
                    <h3 style="color: #ed3237">@lang('messages.Become a volunteer')!!</h3>
                    <p>@lang('messages.You have the power to turn this tearful world into a cheerful one. The question is, will you')?</p>
                    <a class="btn theme-btn" href="{{url('/volunteer/registration')}}">@lang('messages.Join us')</a>
                    <div class="pluses">
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-plus"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}
    <!-- end newsletter -->

@endsection

@push('style')
<link href="{{asset('site-assets/css/lightgallery.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script src='{{asset('site-assets/js/lightgallery-all.min.js')}}'></script>
<script>
    $(document).ready(function () {
        $("#lightgallery").lightGallery();
    });

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
                loadJs();
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                //alert('server not responding...');
            });
    }

    function loadJs() {
        $("#lightgallery").data('lightGallery').destroy(true);
        $("#lightgallery").lightGallery();
    }

    /*new way try end*/
</script>

@endpush