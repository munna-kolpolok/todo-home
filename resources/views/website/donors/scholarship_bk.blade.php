@extends('website.profile_layouts.app')


@section('profile-content')
    <div class="small-device-padding">
        <div class="col-md-9">
            <div style="margin-bottom: 10px" class="breadcomb-list">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                        <div class="breadcomb-wp">
                            <div class="breadcomb-icon">
                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                            </div>
                            <div class="breadcomb-ctn">
                                <h2 style="line-height: 48px; color: #21c292">Scholarship List</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start blog-main-content -->
            <section class="blog-main-content">
                <div class="row blog-grid">
                    @foreach($students as $student)
                        <div class="col col-md-4 col-xs-6" style="margin-bottom: 30px">
                            <div class="post">
                                <div class="entry-media">
                                    <a href="{{ url('donors_scholarship/'.$student->id) }}">
                                        <img src="{{asset($student->student_detail_image)}}" alt="" class="img img-responsive">
                                    </a>
                                </div>
                                <div class="entry-body text-center">

                                    <div class="entry-title">
                                        <h3><a href="{{ url('donors_scholarship/'.$student->id) }}">{{ $student->name or null }}</a></h3>
                                    </div>
                                    <div style="text-align: center">
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                    <input type="hidden" id="base_url" value="{{url('/')}}">
                                    <input type="hidden" id="student-id" value="{{$student->id}}">
                                        <!-- <a href="{{ url('donors_scholarship/'.$student->id) }}" class="btn theme-btn donate-project">Details</a> -->
                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">Donate now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> <!-- end row -->
            </section>
            <!-- end blog-main-content -->
        </div>
    </div>



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
                                                    <a data-toggle="tab" href="#usd">
                                                        <i class="fa fa-usd"></i>
                                                        USD
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" data-toggle="tab" href="#bdt">
                                                        <span>৳</span>
                                                        BDT
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div id="usd" class="tab-pane active">
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
                                                <div id="bdt" class="tab-pane fade">
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
        var parentLocation = this.parentNode.children;
        console.log(parentLocation);
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
                const eight_month_amount_in = Math.ceil((in_amount * 8) / 12);
                const tenth_month_amount_in = Math.ceil((in_amount * 10) / 12);
                const twelve_month_amount_in = Math.ceil((in_amount * 12) / 12);

                //BD payment option
                const first_month_amount_bd = Math.ceil(bd_amount / 12);
                const second_month_amount_bd = Math.ceil((bd_amount * 2) / 12);
                const third_month_amount_bd = Math.ceil((bd_amount * 3) / 12);
                const fifth_month_amount_bd = Math.ceil((bd_amount * 5) / 12);
                const sixth_month_amount_bd = Math.ceil((bd_amount * 6) / 12);
                const eight_month_amount_bd = Math.ceil((bd_amount * 8) / 12);
                const tenth_month_amount_bd = Math.ceil((bd_amount * 10) / 12);
                const twelve_month_amount_bd = Math.ceil((bd_amount * 12) / 12);

                var international_content = `
                    <div class="row">
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="first_month_in" value="${first_month_amount_in}">1 Month with $${first_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="secont_month_in" value="${second_month_amount_in}">2 Month with $${second_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_in" value="${third_month_amount_in}">3 Month with $${third_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="fifth_month_in" value="${fifth_month_amount_in}">5 Month with $${fifth_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="sixth_month_in" value="${sixth_month_amount_in}">5 Month with $${sixth_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="eight_month_in" value="${eight_month_amount_in}">8 Month with $${eight_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="tenth_month_in" value="${tenth_month_amount_in}">10 Month with $${tenth_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="twelve_month_in" value="${twelve_month_amount_in}">12 Month with $${twelve_month_amount_in} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                               <input type="radio" id="custom_in" name="amount">
                               <input class="custom_amount" type="number" name="custom_amount" placeholder="custom amount" min="${first_month_amount_in}">
                       </div>
                    </div>
                `;
                //show in model
                $('#amount-options-in').html(international_content);

                var bd_content = `
                    <div class="row">
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="first_month_bd" value="${first_month_amount_bd}">1 Month with ৳${first_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="secont_month_bd" value="${second_month_amount_bd}">2 Month with ৳${second_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_bd" value="${third_month_amount_bd}">3 Month with ৳${third_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="fifth_month_bd" value="${fifth_month_amount_bd}">5 Month with ৳${fifth_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="sixth_month_bd" value="${sixth_month_amount_bd}">5 Month with ৳${sixth_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="eight_month_bd" value="${eight_month_amount_bd}">8 Month with ৳${eight_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="tenth_month_bd" value="${tenth_month_amount_bd}">10 Month with ৳${tenth_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="twelve_month_bd" value="${twelve_month_amount_bd}">12 Month with ৳${twelve_month_amount_bd} </label>
                       </div>
                       <div class="col-md-4">
                          <label class="radio-inline">
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