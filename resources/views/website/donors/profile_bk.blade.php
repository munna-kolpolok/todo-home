@extends('website.layouts.app')


@section('main-content')
    <section class="shop-main-content section-padding">
        <div class="container">
            
            <h3>Welcome, {{ Auth::user()->name }}</h3>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified">
                <li class="active">
                    <a data-toggle="tab" href="#inbox-id">
                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                        Inbox
                    </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#scholarship-id">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        Scholarship
                    </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#report-id">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Repots
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
            	<!-- Inbox start -->
                <div id="inbox-id" class="tab-pane active">
                	<!-- <div class="box-header">
                		<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Inbox")</button>
                	</div> -->

                	@if(session()->has('message'))
						<div class="alert alert-success alert-dismissable">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong>{{ session()->get('message') }}</strong>
						</div>
					@endif

					@if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif

                    <div class="box-body">
						<table id="example1" class="table table-bordered">
							<caption><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Inbox")</button></caption>
						<thead>
						<tr class="success">
							<th>@lang('messages.Serial No.')</th>
							<th>@lang('messages.Sector')</th>
							<th>@lang('messages.Payment')</th>
							<th>@lang('messages.Amount')</th>
							<th>@lang('messages.Slip No')</th>
							<th>@lang('messages.Message')</th>
							<th>@lang('messages.Agent Message')</th>
							<th>@lang('messages.Clarification Message')</th>
							<th>@lang('messages.Actions')</th>
						</tr>
						</thead>
						<tbody>
							@foreach($inbox_lists as $key=>$inbox)
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ $inbox->sector->name or null }}</td>
								<td>{{ $inbox->payment_method->name or null }}</td>
								<td>{{ $inbox->amount or null }}</td>
								<td>{{ $inbox->slip_no or null }}</td>
								<td>@if(!empty($inbox->donor_message))<pre>{{ $inbox->donor_message or null }}</pre>@endif</td>
								<td>@if(!empty($inbox->agent_message))<pre>{{ $inbox->agent_message or null }}</pre>@endif</td>

								<td>@if(!empty($inbox->donor_clarification))<pre>{{ $inbox->donor_clarification or null }}</pre>@endif</td>

								<td>
									@if(!empty($inbox->attachment))
									<a href="{{ url($inbox->attachment)}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('messages.Attachment')" target="_blank"><i class="fa fa-paperclip"></i></a>
									@endif

									@if($inbox->status=='1')
										@if($inbox->need_clarification=='1')

										<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#clarification_modal" onclick="clarification_modal({{ $inbox->id}})" title="@lang('messages.Clarification')">@lang("messages.Clarification")</button>


										@endif

									{!! Form::open(['action' => ['Website\DonorsController@destroy',$inbox->id],'method' => 'delete','style'=>'display:inline']) !!}
									<button class="btn btn-danger btn-sm"  onclick="return confirm('Are you sure to delete this?')" data-toggle="tooltip" title="@lang('messages.Delete')"><i class="fa fa-times"></i></button>
									{!! Form::close() !!}
									@endif

								</td>
							</tr>
							@endforeach
						</tbody>
						</table>
					</div>

					<!-- modal start -->
					<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">@lang("messages.Add Inbox")</h4>
								</div>
								{!! Form::open(['action' => 'Website\DonorsController@store','files'=>true, 'id' => 'inbox-add-form','class'=>'form-horizontal']) !!}
								<div class="modal-body">
									<div class="box-body">
					                  	<div class="form-group">
									      <label class="control-label col-sm-2" for="email">@lang("messages.Sector"):</label>
									      <div class="col-sm-10">
									        <select class="form-control" name="sector_id" id="sector_id">
									        	@foreach($sectors as $sector)
									        	<option value="{{ $sector->id }}">{{ $sector->name }}</option>
									        	@endforeach
									        </select>
									      </div>
									    </div>	
									    <div class="form-group">
									      <label class="control-label col-sm-2" for="email">@lang("messages.Payment"):</label>
									      <div class="col-sm-10">
									        <select class="form-control" name="payment_method_id" id="payment_method_id">
									        	@foreach($payment_methods as $payment_method)
									        	<option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
									        	@endforeach
									        </select>
									      </div>
									    </div>

									    <div class="form-group">
									      <label class="control-label col-sm-2" for="email">@lang("messages.Amount")<span class="la-required">*</span>:</label>
									      <div class="col-sm-10">
									        <input type="number" class="form-control" id="amount" placeholder="@lang("messages.Enter Amount In Taka")" name="amount" required="1" min="1">
									      </div>
									    </div>

									    <div class="form-group">
									      <label class="control-label col-sm-2" for="pwd">@lang("messages.Slip No"):</label>
									      <div class="col-sm-10">          
									        <input type="text" class="form-control" id="slip_no" placeholder="@lang("messages.Enter Slip No")" name="slip_no">
									      </div>
									    </div>

									    <div class="form-group">
									      <label class="control-label col-sm-2" for="pwd">@lang("messages.Message"):</label>
									      <div class="col-sm-10">          
									        <textarea  class="form-control" name="donor_message" id="donor_message" placeholder="@lang("messages.Enter Your Message")"></textarea>
									      </div>
									    </div>

									    <div class="form-group">
									      <label class="control-label col-sm-2" for="pwd">@lang("messages.Attachment"):</label>
									      <div class="col-sm-10">          
									        <input type="file" id="attachment" name="attachment">
									      </div>
									    </div>

									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
									{!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
								</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
					<!-- modal end -->

					<!-- Clarification modal start -->
					<div class="modal fade" id="clarification_modal" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">@lang("messages.Add Clarification")</h4>
								</div>
								{!! Form::open(['url' => 'donors/inbox_clarification','id' => 'inbox-add-form','class'=>'form-horizontal']) !!}
								<div class="modal-body">
									<div class="box-body">
					                  	<input type="hidden" name="inbox_id" id="inbox_id">

									    <div class="form-group">
									      <label class="control-label col-sm-2" for="pwd">@lang("messages.Message"):</label>
									      <div class="col-sm-10">          
									        <textarea  class="form-control" name="donor_clarification" id="donor_clarification" placeholder="@lang("messages.Enter Your Clarification")"></textarea>
									      </div>
									    </div>

									    

									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
									{!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
								</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
					<!-- Clarification modal end -->

                </div>
                <!-- Inbox end -->

                <!-- scholarship start -->
                <div id="scholarship-id" class="tab-pane fade">
                    
                </div>
                <!-- scholarship end -->

                <!-- Reports start -->
                <div id="report-id" class="tab-pane fade">
                    
                </div>
                <!-- Reports end -->
            </div>

        </div>
    </section>      
    
@endsection

<script type="text/javascript">
	function clarification_modal(id)
	{
		$('#inbox_id').val(id);
		//alert(id);
	}
</script>

