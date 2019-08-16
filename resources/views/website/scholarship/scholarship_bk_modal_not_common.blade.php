@extends('website.layouts.app')


@section('main-content')

<!-- start page-title -->    
{{--<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($settings->scholarship_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1><span class="title-custom-color">Sponsor</span> Us</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Scholarships</li>
            </ol>
            <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>
        </div>
    </div> <!-- end container -->
</section>--}}
<!-- end page-title -->
    <!-- start shop-main-content -->
    <section class="shop-main-content section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-md-12">
                    <div class="shop-content">
                        @forelse($students as $student)
                            <div class="grid">
                                <div class="box">
                                    <div class="img-holder">
                                        <!--student smile source image-->
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                        <!--Image overlay-->
                                       {{-- <div class="image-overlay">
                                            <div class="display-details-text">
                                                <a href="{{url('scholarship/details/'.$student->id)}}">
                                                    --}}{{--<i class="fa fa-link" aria-hidden="true"></i> --}}{{--&nbsp; &nbsp;{{str_limit($student->biography, 350)}}
                                                    <span style="color: red">continue reading..</span>
                                                </a>
                                            </div>
                                        </div>--}}

                                        <a href="{{url('scholarship/details/'.$student->id)}}">
                                            <img src="{{asset($student->student_image)}}" alt
                                                 class="img img-responsive">
                                        </a>
                                    </div>
                                    <div class="details text-center">
                                        <h3>
                                            <a href="{{url('scholarship/details/'.$student->id)}}">{{$student->name}}</a>
                                        </h3>
                                        <p class="price-bd">৳{{intval($student->scholarship_amount)}}</p>
                                        <p class="donate-status">Yearly</p>
                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word;">
                                            <a href="{{url('scholarship/details/'.$student->id)}}">
                                                {{ str_limit($student->biography, 100) }}
                                                <span style="color: #ed323799">Read more</span>
                                            </a>
                                        </p>
                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">Sponsor</a>
                                        {{--<div class="price">
                                            <span class="current-price">${{ceil($student->scholarship_amount * $settings->tk_to_usd)}}</span>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Empty Scholarship List</p>
                        @endforelse
                    </div> <!-- end shop-content -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end shop-main-content -->

    <!--Donate Modal-->
    <!-- Modal -->
    <div class="modal fade donate-modal" id="donate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content scholarship-modal">
                <div class="modal-header modal-header-custom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <div class="col-md-6 col-centered">
                            <div id="modal-header-wrapper" class="text-center">
                                <img id="smile-image" src="" alt="image" width="100px" height="100px">
                                {{--<h3 class="first-heading">Abdur Rahim</h3>--}}
                                <h4 class="second-heading">
                                    <span class="smilling-emoji">😊</span> Thanks For Sponsor Me.<span
                                            class="smilling-emoji">😊</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-padding-md">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="donate-client">
                                        <div id="account-tab">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-justified">
                                                <li class="active">
                                                    <a class="nav-link" data-toggle="tab" href="#bdt">
                                                        <span>৳</span>
                                                        BDT
                                                    </a>
                                                </li>

                                                <li>
                                                    <a data-toggle="tab" href="#usd">
                                                        <i class="fa fa-usd"></i>
                                                        USD
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div id="usd" class="tab-pane fade">
                                                    <div class="amount">
                                                        <form method="POST" id="payment-form-in"
                                                              role="form" action="{{url('/pay_with_paypal')}}">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="student_id" class="student_id">
                                                            <input type="hidden" name="donate_way" value="3">
                                                            <input type="hidden" name="user_id" value="{{ Auth::id() or null }}">

                                                            <div id="amount-options-in"></div>
                                                            @include('website.layouts.donate_paypal_button')
                                                        </form>
                                                    </div>
                                                </div>
                                                <div id="bdt" class="tab-pane active">
                                                    <div class="buy-wrapper">
                                                        <div class="amount">
                                                            <form method="POST" id="payment-form-bd"
                                                                  role="form" action="{{url('/donation_confirmation')}}">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="student_id" class="student_id">
                                                            <input type="hidden" name="donate_way" value="3">
                                                            <input type="hidden" name="user_id" value="{{ Auth::id() or null }}">

                                                                <div id="amount-options-bd"></div>

                                                                
                                                                @include('website.layouts.donate_ssl_button')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Donate Modal-->
@endsection

@push('scripts')
<script>
    /*When click donate button*/
    $('.donate').click(function (e) {

        //dynamic image load
        var parentLocation = this.parentNode.parentNode.children[0].children;
        var srcSmileImageIs = parentLocation[0].id;
        var imageSrc = $('#' + srcSmileImageIs).val();
        var base_url = $('#base_url').val() + '/';
        var image_src = base_url + imageSrc;
        $('#smile-image').attr('src', image_src);

        /*Load Payment options*/
        const stdId = parentLocation[2].value;
        $('.student_id').val(stdId);
        $.ajax({
            url: "{{url('get-scholarship-amount')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id: stdId
            },
            success: function (response) {
                var bd_amount = Math.ceil(response.bd);
                var in_amount = Math.ceil(response.in);

                //international payment option
                const first_month_amount_in = Math.ceil(in_amount / 12);
                const second_month_amount_in = Math.ceil((in_amount * 2) / 12);
                const third_month_amount_in = Math.ceil((in_amount * 3) / 12);
                const fifth_month_amount_in = Math.ceil((in_amount * 5) / 12);
                const sixth_month_amount_in = Math.ceil((in_amount * 6) / 12);
                const ninegth_month_amount_in = Math.ceil((in_amount * 9) / 12);
                const tenth_month_amount_in = Math.ceil((in_amount * 10) / 12);
                const twelve_month_amount_in = Math.ceil((in_amount * 12) / 12);

                //BD payment option
                const first_month_amount_bd = Math.ceil(bd_amount / 12);
                const second_month_amount_bd = Math.ceil((bd_amount * 2) / 12);
                const third_month_amount_bd = Math.ceil((bd_amount * 3) / 12);
                const fifth_month_amount_bd = Math.ceil((bd_amount * 5) / 12);
                const sixth_month_amount_bd = Math.ceil((bd_amount * 6) / 12);
                const ninegth_month_amount_bd = Math.ceil((bd_amount * 9) / 12);
                const tenth_month_amount_bd = Math.ceil((bd_amount * 10) / 12);
                const twelve_month_amount_bd = Math.ceil((bd_amount * 12) / 12);

                var international_content = `
                    <div class="row">
                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="first_month_in" value="${first_month_amount_in}">$${first_month_amount_in} (Expense of one kid for one month)</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_in" value="${third_month_amount_in}">$${third_month_amount_in} (Expense of one kid for three month)</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="six_month_in" value="${sixth_month_amount_in}">$${sixth_month_amount_in} (Expense of one kid for six month)</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="nine_month_in" value="${ninegth_month_amount_in}">$${ninegth_month_amount_in} (Expense of one kid for nine month)</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="twelve_month_in" value="${twelve_month_amount_in}">$${twelve_month_amount_in} (Expense of one kid for one year)</label>
                       </div>
                       <div class="col-md-6">
                          <label class="radio-inline" style="display: block">
                               <input type="radio" id="custom_in" name="amount">
                               <input class="custom_amount" type="number" name="custom_amount" placeholder="custom amount" min="${first_month_amount_in}">
                       </div>
                    </div>
                `;
                //show in model
                $('#amount-options-in').html(international_content);

                var bd_content = `
                    <div class="row">
                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="first_month_bd" value="${first_month_amount_bd}">৳${first_month_amount_bd} (Expense of one kid for one month)</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_bd" value="${third_month_amount_bd}">৳${third_month_amount_bd} (Expense of one kid for three month) </label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="sixth_month_bd" value="${sixth_month_amount_bd}">৳${sixth_month_amount_bd} (Expense of one kid for six months) </label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="nine_month_bd" value="${ninegth_month_amount_bd}">৳${ninegth_month_amount_bd} (Expense of one kid for nine months) </label>
                       </div>


                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="twelve_month_bd" value="${twelve_month_amount_bd}">৳${twelve_month_amount_bd} (Expense of one kid for one year)</label>
                       </div>
                       <div class="col-md-6">
                          <label class="radio-inline" style="display: block">
                               <input type="radio" id="custom_bd" name="amount">
                               <input class="custom_amount" type="number" name="custom_amount" placeholder="custom amount" min="${first_month_amount_bd}">
                       </div>
                    </div>
                `;
                //show in model
                $('#amount-options-bd').html(bd_content);

                $('.custom_amount').keyup(function () {
                    var rid = this.previousElementSibling.id;
                    $('#' + rid).prop("checked", true);
                });

            }
        });

    });


   /* $('input[type="button"]').click(function (e) {
        var rid = this.previousElementSibling.id;
        $('#' + rid).prop("checked", true);
    })*/
</script>
@endpush