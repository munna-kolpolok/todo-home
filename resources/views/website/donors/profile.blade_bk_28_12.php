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
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                hello Home
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="post" class="tab-pane active notika-tab-menu-bg animated flipInX">
                                <div class="content-box-md">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <ul>
                                                    <li>Create post</li>
                                                    <li>New message Post</li>
                                                    <li>Approved Post</li>
                                                    <li>Draft Post</li>
                                                </ul>
                                                
                                            </div>
                                            <div class="col-md-8">
                                                
                                                <!-- blog part start -->
                                                <!-- <div class="row">
                                                    <div class="col-md-6" style="background-color: red">
                                                        <ul>
                                                            <li>500 taka</li>
                                                            <li>One Taka Aahar</li>
                                                            <li>Bkash</li>
                                                            <li>Attachment</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6" style="background-color: green">
                                                        <p>mafadfhjasdf
                                                        asdffaf
                                                        asdfdf</p>
                                                    </div>
                                                </div> -->
                                                <!-- blog part end -->

                                                <div class="post">
                            <div class="media">
                                <img src="images/latest-news/blog-detail/img-1.jpg" alt class="img img-responsive">
                            </div>
                            <div class="post-title-meta">
                                <button class="btn theme-btn">Water</button>
                                <h2>Clean Water Charity - $15,000 funds a well for a village‎ wish your help</h2>
                                <ul>
                                    <li><a href="#">Hasib sharif</a></li>
                                    <li><a href="#">21 feb, 2016</a></li>
                                </ul>
                            </div>
                            <div class="post-body">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
                                <p>Which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum genera tors on the Internet tend to repeat predefined chunks as necessary, making this the first true genera tor on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence </p>
                            </div>
                            <div class="gallery-post">
                                <div class="gallery">
                                    <div>
                                        <img src="images/latest-news/blog-detail/img-2.jpg" alt class="img img-responsive">
                                    </div>
                                    <div>
                                        <img src="images/latest-news/blog-detail/img-3.jpg" alt class="img img-responsive">
                                    </div>
                                </div>
                                
                                <h3>Lorem Ipsum is not simply random text. </h3>
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text</p>
                            </div>
                        </div> 

                                                <!-- comment messages start -->
                                           
                                                <!-- comment messages end -->




                                                <!-- comment box start -->
                                                <!-- <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="" placeholder="Enter Comments">
                                                    </div>
                                                </div> -->
                                                <!-- comment box end -->



                                                <div class="comments">
                            <div class="title">
                                <h3><span>2</span> comments</h3>
                            </div>

                            <ol>
                                <li>
                                    <div class="article">
                                        <div class="author-pic">
                                            <img src="images/latest-news/comments/img-1.jpg" alt>
                                        </div>
                                        <div class="details">
                                            <div class="author-meta">
                                                <div class="name"><h4>Hasib sharif</h4></div>
                                                <div class="date"><span>2 hours ago</span></div>
                                            </div>
                                            <div class="comment-content">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                            </div>
                                            <div class="replay">
                                                <button>Replay</button>
                                            </div>
                                        </div>
                                    </div>
                                    <ol>
                                        <li>
                                            <div class="article">
                                                <div class="author-pic">
                                                    <img src="images/latest-news/comments/img-2.jpg" alt>
                                                </div>
                                                <div class="details">
                                                    <div class="author-meta">
                                                        <div class="name"><h4>Ahmad sharif</h4></div>
                                                        <div class="date"><span>2 hours ago</span></div>
                                                    </div>
                                                    <div class="comment-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                                    </div>
                                                    <div class="replay">
                                                        <button>Replay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="article">
                                                <div class="author-pic">
                                                    <img src="images/latest-news/comments/img-2.jpg" alt>
                                                </div>
                                                <div class="details">
                                                    <div class="author-meta">
                                                        <div class="name"><h4>Ahmad sharif</h4></div>
                                                        <div class="date"><span>2 hours ago</span></div>
                                                    </div>
                                                    <div class="comment-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                                    </div>
                                                    <div class="replay">
                                                        <button>Replay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>

                                <li>
                                    <div class="article">
                                        <div class="author-pic">
                                            <img src="images/latest-news/comments/img-1.jpg" alt>
                                        </div>
                                        <div class="details">
                                            <div class="author-meta">
                                                <div class="name"><h4>Hasib sharif</h4></div>
                                                <div class="date"><span>2 hours ago</span></div>
                                            </div>
                                            <div class="comment-content">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                            </div>
                                            <div class="replay">
                                                <button>Replay</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>

                            <div class="comment-respond">
                                <h3>Post your comment</h3>
                                <form class="clearfix">
                                    <div class="col col-md-4">
                                        <input type="text" class="form-control" placeholder="username..">
                                    </div>
                                    <div class="col col-md-4">
                                        <input type="email" class="form-control" placeholder="email address..">
                                    </div>
                                    <div class="col col-md-4">
                                        <input type="text" class="form-control" placeholder="website..">
                                    </div>
                                    <div class="col col-xs-12">
                                        <textarea class="form-control" placeholder="write.."></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn theme-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end comments -->
                    </div>


                    <div class="comments">
                            <div class="title">
                                <h3><span>2</span> comments</h3>
                            </div>

                            <ol>
                                <li>
                                    <div class="article">
                                        <div class="author-pic">
                                            <img src="images/latest-news/comments/img-1.jpg" alt>
                                        </div>
                                        <div class="details">
                                            <div class="author-meta">
                                                <div class="name"><h4>Hasib sharif</h4></div>
                                                <div class="date"><span>2 hours ago</span></div>
                                            </div>
                                            <div class="comment-content">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                            </div>
                                            <div class="replay">
                                                <button>Replay</button>
                                            </div>
                                        </div>
                                    </div>
                                    <ol>
                                        <li>
                                            <div class="article">
                                                <div class="author-pic">
                                                    <img src="images/latest-news/comments/img-2.jpg" alt>
                                                </div>
                                                <div class="details">
                                                    <div class="author-meta">
                                                        <div class="name"><h4>Ahmad sharif</h4></div>
                                                        <div class="date"><span>2 hours ago</span></div>
                                                    </div>
                                                    <div class="comment-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                                    </div>
                                                    <div class="replay">
                                                        <button>Replay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="article">
                                                <div class="author-pic">
                                                    <img src="images/latest-news/comments/img-2.jpg" alt>
                                                </div>
                                                <div class="details">
                                                    <div class="author-meta">
                                                        <div class="name"><h4>Ahmad sharif</h4></div>
                                                        <div class="date"><span>2 hours ago</span></div>
                                                    </div>
                                                    <div class="comment-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                                    </div>
                                                    <div class="replay">
                                                        <button>Replay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>

                                <li>
                                    <div class="article">
                                        <div class="author-pic">
                                            <img src="images/latest-news/comments/img-1.jpg" alt>
                                        </div>
                                        <div class="details">
                                            <div class="author-meta">
                                                <div class="name"><h4>Hasib sharif</h4></div>
                                                <div class="date"><span>2 hours ago</span></div>
                                            </div>
                                            <div class="comment-content">
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                                            </div>
                                            <div class="replay">
                                                <button>Replay</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>

                            <div class="comment-respond">
                                <h3>Post your comment</h3>
                                <form class="clearfix">
                                    <div class="col col-md-4">
                                        <input type="text" class="form-control" placeholder="username..">
                                    </div>
                                    <div class="col col-md-4">
                                        <input type="email" class="form-control" placeholder="email address..">
                                    </div>
                                    <div class="col col-md-4">
                                        <input type="text" class="form-control" placeholder="website..">
                                    </div>
                                    <div class="col col-xs-12">
                                        <textarea class="form-control" placeholder="write.."></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn theme-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end comments -->
                    

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
            </div>
        </div>
        <!-- Main Menu area End-->

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
                return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
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


