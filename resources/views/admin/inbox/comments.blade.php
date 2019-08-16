@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}">@lang('messages.Inbox')</a>
@endsection
@section("section", trans("messages.Inbox"))
@section("section_url", url(config('laraadmin.adminRoute') . '/inboxes'))
@section("sub_section", trans("messages.Comments"))

@section("htmlheader_title", "Inbox Comments")

<style>
    ul.list-group:after {
        clear: both;
        display: block;
        content: "";
    }

    .list-group-item {
        float: left;
        margin-left: 10px;
        background-color: #000 !important;
        color: #fff;
    }
</style>

@section("main-content")

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="box box-success">
        <div class="box-header" style="background-color: #10cfbd">
            <ul class="list-group" style="margin-bottom: 0">
                <li class="list-group-item">@lang('messages.Donor Name') : {{$comments->user->name}}</li>
                <li class="list-group-item">@lang('messages.Donor Email') : {{$comments->user->email}}</li>
                <li class="list-group-item">@lang('messages.Sector') : {{$comments->sector->name}}</li>
                <li class="list-group-item">@lang('messages.Amount') : {{$comments->amount}}</li>
                <li class="list-group-item">@lang('messages.Status') :
                    @if($comments->status==1)
                        @lang('messages.Draft')
                    @elseif($comments->status==2)
                        @lang('messages.Need Clarification')
                    @elseif($comments->status==3)
                        @lang('messages.Approved')
                    @elseif($comments->status==4)
                        @lang('messages.Disapproved')
                    @endif
                </li>
            </ul>
        </div>
        {{--
            {!! Form::open(['route' => [config('laraadmin.adminRoute') . '.inboxes.update', $inbox->id ], 'method'=>'PUT', 'id' => 'inboxes-edit-form']) !!}
        --}}
        <div class="box-body">
            <div class="row">
                @if(count($comments->inboxChat)>0)
                <div class="col-md-12" id="scroll-comments" style="height: 45vh; overflow-y: scroll">
                    @foreach($comments->inboxChat as $comment)
                        @if($comment->is_admin == 1)
                           <div>
                               <p class="text-success" style="padding: 0; margin: 0;">{{$comment->agent->name or null }}
                                   : {{ $comment->created_at or null }}</p>
                               @if($comment->is_file==1)
                                   <a href="{{ url($comment->comments)}}"><i class="fa fa-download" aria-hidden="true"></i> Click here to see the attachment</a>
                               @else
                                   <div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px; min-height: 25px">{{ $comment->comments or null }}</div>
                               @endif
                           </div>

                        @elseif($comment->is_admin==0)
                            <div class="alert alert-warning">
                                <p  style="padding: 0; margin: 0">{{$comment->customer->name or null }}
                                    : {{ $comment->created_at or null }}</p>
                                @if($comment->is_file==1)
                                    <a href="{{ url($comment->comments)}}"><i class="fa fa-download" aria-hidden="true"></i> Click here to see the attachment</a>
                                @else
                                    <div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px; min-height: 25px; color:black;">{{ $comment->comments or null }}</div>
                                @endif
                            </div>
                        @endif


                    @endforeach
                </div>
                @else
                <div class="col-md-12">
                    <h3>There is no comments</h3>
                </div>
                @endif
            </div>

            @if($comments->status<'3')
            <div class="row">
                <div class="col-md-12">
                    <div class="comments">
                        {!! Form::open(['action' => 'Admin\InboxesController@store', 'files' => true]) !!}
                        <input type="hidden" name="inbox_id" value="{{ $inbox_id }}">
                        <div class="form-group">
                            <textarea placeholder="Write your comment here!" class="form-control pb-cmnt-textarea" name="comments" id="comments"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <input type="file" name="comment_attachment" class="comment_attachment">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success pull-right">Send</button>
                </div>
                
                    
                {!! Form::close() !!}

            </div>
            @endif
        </div>


        {{--
                {!! Form::close() !!}
        --}}

    </div>




@endsection

@push('scripts')
<script type="text/javascript">

    $(document).ready(function () {
        $('#comments').focus();
        var element = document.getElementById("scroll-comments");
        element.scrollTop = element.scrollHeight;
    });

    $('.pb-cmnt-textarea').keydown(function (event) {
        // enter has keyCode = 13, change it if you want to use another button
        if (event.keyCode == 13) {
            this.form.submit();
            return false;
        }
    });

    $('.comment_attachment').on('change', function () {
        this.form.submit();
        return false;
    });

</script>
@endpush
