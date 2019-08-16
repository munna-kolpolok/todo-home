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
                            <li class="active"><a data-toggle="tab" href="#donation"><i
                                            class="notika-icon notika-app"></i> Donation Clarification</a>
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
                            <div id="donation" class="tab-pane active notika-tab-menu-bg animated flipInX">
                                <div class="content-box-md">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-wrapper">
                                                <div class="form-heading text-center">
                                                    <h4>Add Clarification</h4>
                                                </div>
                                                <div class="main-form">
                                                    {!! Form::open(['action' => 'Website\DonorsController@store','files'=>true, 'id' => 'inbox-add-form','class'=>'form-horizontal']) !!}
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2"
                                                               for="email">@lang("messages.Donate Amount")<span
                                                                    class="la-required">*</span>:</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="amount"
                                                                   placeholder="@lang("messages.Enter Amount")"
                                                                   name="amount" required="1" min="1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2"
                                                               for="email">@lang("messages.Currency"):</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="currency"
                                                                    id="currency">
                                                                @foreach($currency_lists as $currency_list)
                                                                    <option value="{{ $currency_list->id }}">{{ $currency_list->currency_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2"
                                                               for="email">@lang("messages.Payment"):</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="payment_method_id"
                                                                    id="payment_method_id">
                                                                @foreach($payment_methods as $payment_method)
                                                                    <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2"
                                                               for="email">@lang("messages.Donation Sector"):</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="sector_id"
                                                                    id="sector_id">
                                                                @foreach($sectors as $sector)
                                                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2"
                                                               for="pwd">@lang("messages.Message"):</label>
                                                        <div class="col-sm-10">
                                                        <textarea class="form-control" name="donor_message"
                                                                  id="donor_message"
                                                                  placeholder="@lang("messages.Enter Your Message")"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2"
                                                               for="pwd">@lang("messages.Attachment"):</label>
                                                        <div class="col-sm-10 text-center">
                                                            <input type="file" id="attachment" name="attachment">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-10">
                                                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-primary']) !!}
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="chat-wrapper">
                                                <div class="chat_window">
                                                    <div class="top_menu">
                                                        <div class="buttons">
                                                            <div class="button close"></div>
                                                            <div class="button minimize"></div>
                                                            <div class="button maximize"></div>
                                                        </div>
                                                        <div class="title">Chat</div>
                                                    </div>
                                                    <ul class="messages"></ul>
                                                    <div class="bottom_wrapper clearfix">
                                                        <div class="message_input_wrapper"><input class="message_input"
                                                                                                  placeholder="Type your message here..."/>
                                                        </div>
                                                        <div class="send_message">
                                                            <div class="icon"></div>
                                                            <div class="text">Send</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="message_template">
                                                    <li class="message">
                                                        <div class="avatar"></div>
                                                        <div class="text_wrapper">
                                                            <div class="text"></div>
                                                        </div>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                    <tr class="success">
                                                        <th scope="col">@lang('messages.Serial No.')</th>
                                                        <th scope="col">@lang('messages.Payment')</th>
                                                        <th scope="col">@lang('messages.Amount')</th>
                                                        <th scope="col">@lang('messages.Message')</th>
                                                        <th scope="col">@lang('messages.Agent Message')</th>
                                                        <th scope="col">@lang('messages.Clarification Message')</th>
                                                        <th scope="col">@lang('messages.Actions')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($inbox_lists as $key=>$inbox)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $inbox->payment_method->name or null }}</td>
                                                            <td>{{ $inbox->amount or null }}</td>
                                                            <td>@if(!empty($inbox->donor_message))
                                                                    <pre>{{ $inbox->donor_message or null }}</pre>@endif
                                                            </td>
                                                            <td>@if(!empty($inbox->agent_message))
                                                                    <pre>{{ $inbox->agent_message or null }}</pre>@endif
                                                            </td>

                                                            <td>@if(!empty($inbox->donor_clarification))
                                                                    <pre>{{ $inbox->donor_clarification or null }}</pre>@endif
                                                            </td>

                                                            <td>
                                                                {{--  @if(!empty($inbox->attachment))
                                                                      <a href="{{ url($inbox->attachment)}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('messages.Attachment')" target="_blank"><i class="fa fa-paperclip"></i></a>
                                                                  @endif--}}

                                                                @if($inbox->status=='1'){{--
                                                                    @if($inbox->need_clarification=='1')

                                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#clarification_modal" onclick="clarification_modal({{ $inbox->id}})" title="@lang('messages.Clarification')">@lang("messages.Clarification")</button>


                                                                    @endif--}}

                                                                {!! Form::open(['action' => ['Website\DonorsController@destroy',$inbox->id],'method' => 'delete','style'=>'display:inline']) !!}
                                                                <button class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure to delete this?')"
                                                                        data-toggle="tooltip"
                                                                        title="@lang('messages.Delete')"><i
                                                                            class="fa fa-times"></i></button>
                                                                {!! Form::close() !!}
                                                                <button id="chat-btn" class="btn btn-success btn-sm">
                                                                    <i class="fa fa-commenting-o"
                                                                       aria-hidden="true"></i>
                                                                    Chat
                                                                </button>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="notika-icon notika-dollar"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <input type="text"  class="form-control" placeholder="Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <div class="chosen-select-act fm-cmp-mg">
                                                            <select select2 data-placeholder="Choose a Country...">
                                                                <option>Chose a cause</option>
                                                                <option value="United States">United States</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="Afghanistan">Afghanistan</option>
                                                                <option value="Aland Islands">Aland Islands</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <div class="chosen-select-act fm-cmp-mg">
                                                            <select data-placeholder="Choose a Country...">
                                                                <option value="United States">United States</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="Afghanistan">Afghanistan</option>
                                                                <option value="Aland Islands">Aland Islands</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <input type="number" class="form-control"
                                                               placeholder="Slip Number">
                                                    </div>
                                                </div>
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"
                                                               placeholder="Enter Your Message">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">RIght</div>
                                        </div>
                                    </div>--}}
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


