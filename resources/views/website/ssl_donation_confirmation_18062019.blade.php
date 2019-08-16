<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<html>
<head>
    <title>Bidyanondo</title>

    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('uploads/settings/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset($setting->favicon)}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset($setting->favicon2)}}">
    <link rel="manifest" href="{{asset('uploads/settings/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('uploads/settings/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    

    <link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('la-assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('jquery-confirm-v3.2.0/css/jquery-confirm.min.css') }}">
    <style>
        input[type='number'] {
            -moz-appearance:textfield;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
        .donation-confirm-body {
            background-color: rgba(128, 128, 128, 0.1);
            background-image: url('{{ asset('site-assets/images/1.jpg') }}');

            width: 100%;
            height: 90vh;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
            /* overflow: hidden;*/
        }

        .donation-top-bar {
            min-height: 100px;
            background-color: #0000004d;
            padding: 10px 10%;

        }

        @media only screen and (max-width: 600px) {
            .donation-confirm-logo {
                display: block;
                margin: auto;
            }
        }

        .donation-confirm-top-tex {
            color: #f5f5f5;
            margin: 30px 0;
            float: right;
            font-size: 15px;
            font-weight: 300;
            font-family: 'Roboto', sans-serif !important;
        }

        .donation-confirm-info, .footer {
            margin: 10px 8%;
        }

        .panel-heading, .btn-success {
            background: #0094D6 !important;
            border: 1px solid #0094D6 !important;
            color: #fff !important;

        }

        .panel-primary {
            margin: 5px;
            border-color: #0094D6;

        }

        .panel-title {
            color: #f5f5f5;
            line-height: 30px;
            font-size: 20px;
        }

        .required {
            color: red;
            font-size: 15px;
            font-weight: bold;
        }

        .btn-success {
            line-height: 33px;
            font-size: 18px;
            font-weight: 700;
        }

        .btn-success:hover {
           /* font-size: 19px;*/
            color: #ffffff;
            font-weight: 700;
            box-sizing: border-box;
            background-color: #449D44!important;
        }

        @media screen and (min-width: 992px) {
            .flex-div {
                display: flex !important;
                flex-direction: row;
                flex-wrap: wrap;
            }
            .porwedby {
                float: right;

            }


        }
        @media only screen and (max-width: 600px) {
            .porwedby {
                display: block;

            }
        }



    </style>

</head>
<body style="" class="donation-confirm-body">
<div class="container-fluid">

    <div class="row  donation-top-bar" style="border-bottom: 2px solid #0094D6;">
        <div class=" col-lg-6 col-md-3 col-sm-3">
            <!-- <img class="donation-confirm-logo" src="{{ asset('site-assets/images/logo.jpg') }}" width="80" height="80"
                 alt="Bidyanondo"> -->
            <img class="donation-confirm-logo" src="{{asset($setting->logo)}}" alt="Bidyanondo">
        </div>
        <div class=" col-lg-6 col-md-9 col-sm-9" style="">
            <p class="donation-confirm-top-tex">Having Problems? Call Support: <strong style="font-size: 17px;">{{$setting->contact_no }} </strong></p>
        </div>
    </div>


    <!-- Donation confirmation info start -->
    <div class="row donation-confirm-info flex-div">
        <!-- Donor info part start -->
        <div class="col col-md-5 donation-confirm-info-1 ">
            <div class="row panel panel-primary" style="margin:5px; height: 100%">
                <div class="panel-heading">
                    <h3 class="panel-title">Your Donation <i class="fa fa-money  pull-right" aria-hidden="true"
                                                             style="font-size:32px"></i></h3>

                </div>

                <div style="min-height:120px;" class="panel-body">
                    <div style="color: #626262; margin: auto; text-align: center;">
                        <p style="font-size: 16px;">
                            <br>
                            Total (BDT) : <span style="font-size: 25px;"> <strong>{{ $total_amount }}
                                    Taka</strong></span>

                        </p>
                        <br>
                        <a href="{{ URL::previous() }}"> <span style="color: #CF3720">Cancel </span> and return to www.bidyanondo.org</a>
                    </div>

                </div>

            </div>
        </div>
         <!-- Donor info part end -->

        <!-- Donor details info start -->
        <div class="col col-md-7 donation-confirm-info-2">
            <div class="row panel panel-primary" style="margin:5px; height: 100%">
                <div class="panel-heading">
                    <h3 class="panel-title">Your Details <i class="fa fa-credit-card  pull-right" aria-hidden="true"
                                                            style="font-size:32px"></i></h3>
                </div>
                <div class="panel-body">
                    <form method="POST" id="donation-confirm-form" role="form" action="{{url('/pay_with_sslcommerz')}}">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <input type="hidden" name="amount" value="{{ $total_amount }}">
                        <input type="hidden" name="comments" value="{{ $comments }}">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                        <input type="hidden" name="student_id" value="{{ $student_id }}">
                        <input type="hidden" name="donate_way" value="{{ $donate_way }}">
                        

                        <div class="form-group">
                            <label for="exampleInputEmail1">Name <span class="required">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter your name (Required)" name='cus_name' id='cus_name' required  minlength="3">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email <span class="required">*</span></label>
                            <input type="email" id="email" class="form-control" placeholder="Enter your email (Required)" name='cus_email' id='cus_email' required >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contact No <span class="required">*</span></label>
                            <input type="number" class="form-control" placeholder="Enter your contact no (Required)" name='cus_phone' id='cus_phone' required minlength="10" min="0" step="1">
                        </div>
                        <button type="submit" class="btn btn-success" id="proceed_payment">Proceed to Payment</button>
                    </form>
                </div>
            </div>

        </div>
        <!-- Donor details info end -->
    </div>
    <!-- Donation confirmation info end -->

    <!-- <div class="row footer">
        <div class="col-md-6"></div>
        <div class="col-md-6"><img class="porwedby" style="height: 70px; width: 160px; margin: 0 auto; background-color: #000000b3"
                                   src="{{asset('site-assets/images/power_002.png')}}" alt="" ></div>
    </div> -->

</div>
</body>

<script src="{{ asset('la-assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('jquery-confirm-v3.2.0/js/jquery-confirm.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        /*Add new row*/
        $("#donation-confirm-form").validate({
            submitHandler: function(form) { 
                var email = $("#email").val();
                if (validateEmail(email)) 
                {
                    $("#proceed_payment").attr("disabled", true);
                    $("#proceed_payment").html("Processing <i class='fa fa-spinner fa-spin'></i>");
                    form.submit(); 
                  } else {
                    $.alert('Enter a valid email address');
                  } 
            }
        });
    });

    function validateEmail(email) {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }


</script>
</html>




 

