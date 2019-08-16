@extends('website.layouts.app')


@section('main-content')
    <section class="shop-main-content section-padding" id="dashboard_padding">
        <!-- Breadcomb area Start-->
        <div class="breadcomb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-list">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="breadcomb-wp">
                                        <div class="breadcomb-icon">
                                            <i class="notika-icon notika-app"></i>
                                        </div>
                                        <div class="breadcomb-ctn">
                                            <h2>Hello, {{\Illuminate\Support\Facades\Auth::user()->name}}</h2>
                                            <p>Welcome to Bidiyanondo <span class="bread-ntd">Admin panel</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                    <div class="breadcomb-report">
                                        {{--
                                                                                    <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></button>
                                        --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcomb area End-->
        <!-- Main Menu area start-->
        <div class="main-menu-area mg-tb-40">
            <div class="container-fluid">

                <ul class="nav nav-tabs nav-justified notika-menu-wrap menu-it-icon-pro">
                    <li><a data-toggle="tab" href="#Home"><i class="notika-icon notika-house"></i> Home</a>
                    </li>
                    <li class="active"><a data-toggle="tab" href="#post"><i
                                    class="notika-icon notika-app"></i> Create Posts</a>
                    </li>
                    <li><a data-toggle="tab" href="#scholarship"><i class="fa fa-graduation-cap"
                                                                    aria-hidden="true"></i>
                            Scholarship</a>
                    </li>
                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="Home" class="tab-pane in notika-tab-menu-bg animated flipInX">
                        <div class="content-box-md">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    hello Home


                                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post" class="tab-pane active notika-tab-menu-bg {{--animated flipInX--}}">
                        <div class="content-box-md">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="profile-menu">
                                        <li>
                                            <a href="#create-post">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                Create post
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-indent" aria-hidden="true"></i>
                                                New message Post
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                Approved Post
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                Draft Post
                                            </a>
                                        </li>
                                    </ul>
                                    <hr>
                                </div>
                                <div class="col-md-9">
                                    <div class="menu-content-load">
                                        <h2>Menu content</h2>

                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="scholarship" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <div class="content-box-md">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        hello scholarship
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('style')
<!-- Notika icon CSS============================================ -->
<link rel="stylesheet" href="{{asset('site-assets/css/notika-custom-icon.css')}}">
<link rel="stylesheet" href="{{asset('site-assets/css/chosen.css')}}">
@endpush

@push('scripts')
<!--  chosen JS============================================ -->
<script src="{{asset('site-assets/js/chosen.jquery.js')}}"></script>
{{--Chat scripts--}}
<script>
    (function () {
        var Message;
        Message = function (arg) {
            this.text = arg.text, this.message_side = arg.message_side;
            this.draw = function (_this) {
                return function () {
                    var $message;
                    $message = $($('.message_template').clone().html());
                    $message.addClass(_this.message_side).find('.text').html(_this.text);
                    $('.messages').append($message);
                    return setTimeout(function () {
                        return $message.addClass('appeared');
                    }, 0);
                };
            }(this);
            return this;
        };
        $(function () {
            var getMessageText, message_side, sendMessage;
            message_side = 'right';
            getMessageText = function () {
                var $message_input;
                $message_input = $('.message_input');
                return $message_input.val();
            };
            sendMessage = function (text) {
                var $messages, message;
                if (text.trim() === '') {
                    return;
                }
                $('.message_input').val('');
                $messages = $('.messages');
                message_side = message_side === 'left' ? 'right' : 'left';
                message = new Message({
                    text: text,
                    message_side: message_side
                });
                message.draw();
                return $messages.animate({scrollTop: $messages.prop('scrollHeight')}, 300);
            };
            $('.send_message').click(function (e) {
                return sendMessage(getMessageText());
            });
            $('.message_input').keyup(function (e) {
                if (e.which === 13) {
                    return sendMessage(getMessageText());
                }
            });
            sendMessage('Hello Philip! :)');
            setTimeout(function () {
                return sendMessage('Hi Sandy! How are you?');
            }, 1000);
            return setTimeout(function () {
                return sendMessage('I\'m fine, thank you!');
            }, 2000);
        });
    }.call(this));
</script>
@endpush


