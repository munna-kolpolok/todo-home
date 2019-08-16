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
        <div class="main-menu-area">
            <div class="container">
                <div id="user-profile">
                    <div class="row">
                        <div  class="col-md-3">
                            <ul class="profile-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        Post
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        Scholarship
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-7">
                            <div id="post-wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="post-list">
                                            <div class="post-create">
                                                <a href="#" class="btn theme-btn btn-block">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    Create Post
                                                </a>
                                            </div>
                                            <div class="post-content">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">September 30th, 2013</h3>
                                                        <div class="post-action">
                                                            <a href="#">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="post-content-inner">
                                                            <div class="post-content-inner-left">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="post-field-title">Amount :</span> 500 tk</li>
                                                                    <li class="list-group-item"><span class="post-field-title">Title :</span> One Taka Ahar</li>
                                                                    <li class="list-group-item"><span class="post-field-title">Payment Method :</span> Bkash</li>
                                                                    <li class="list-group-item">
                                                                        <span class="post-field-title">Attachment :</span>
                                                                        <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="post-content-inner-right">
                                                                <div class="message-box">
                                                                    <div class="alert alert-success" role="alert">
                                                                        Here are all the possible meanings and translations of the word
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="panel panel-info">
                                                                        <div class="panel-body">
                                                                            <div class="media">
                                                                                {{--<div class="media-left">
                                                                                    <img src="{{asset('uploads/students/default/default.png')}}" class="media-object" style="width:45px">
                                                                                </div>--}}
                                                                                <div class="media-body">
                                                                                    <h4 class="media-heading">John Doe <small><i>February 19, 2016</i></small></h4>
                                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                                                </div>
                                                                            </div>
                                                                            <div  style="background: #f6f8fa; padding: 10px; margin-bottom: 10px" class="media">
                                                                                {{--<div class="media-left">
                                                                                    <img src="{{asset('uploads/students/default/default.png')}}" class="media-object" style="width:45px">
                                                                                </div>--}}
                                                                                <div class="media-body">
                                                                                    <h4 class="media-heading">Admin <small><i>February 19, 2016</i></small></h4>
                                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                                                </div>
                                                                            </div>
                                                                            <textarea placeholder="Write your comment here!" class="pb-cmnt-textarea"></textarea>
                                                                            <form class="form-inline">
                                                                                <div class="btn-group">
                                                                                    <button class="btn" type="button"><span class="fa fa-picture-o fa-lg"></span></button>
                                                                                    <button class="btn" type="button"><span class="fa fa-upload"></span></button>
                                                                                </div>
                                                                                <a href="#" class="btn theme-btn pull-right">Send</a>
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
                        <div class="col-md-2">
                            <div class="post-sidebar">
                                <ul class="profile-menu">
                                    <li>
                                        <a href="#">
                                            Approved Post
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            New message Post
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Draft Post
                                        </a>
                                    </li>
                                </ul>
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


