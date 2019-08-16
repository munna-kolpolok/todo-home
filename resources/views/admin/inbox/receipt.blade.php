<!DOCTYPE html>
<html>
<head>
	<title>Receipt</title>
	<meta charset="utf-8">

	<style type="text/css">
		table.border,table.border td,table.border th {
		    border: 1px solid black;
		}
		table.border {
		    border-collapse: collapse;
		    width: 100%;
		}
		/*th {
		    height: 50px;
		}*/
		.text-center {
			text-align: center;
		}
		.text-left {
			text-align: left;
		}
		.text-right {
			text-align: right;
		}
		.active {
			background-color: #CCC;
		}
		p { margin:0 }
	</style>
</head>
<body>
	
	<div style="text-align: center">
		<img src="{{asset('site-assets/images/Biddyanondo-resized.png')}}" alt="" class="img img-responsive">
		<h4>Money Receipt</h4>
	</div>
   

   <table class="border">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Sector</th>
			<th>Payment</th>
			<th>Bill ({{ $donation->currency->currency_code or null }})</th>
		</tr>

		<tr>
			<td>{{ $donation->inbox->user->name or null }}</td>
			<td>{{ $donation->inbox->user->email or null }}</td>
			<td>{{ $donation->inbox->sector->name or null }}</td>
			<td>{{ $donation->inbox->payment_method->name or null }}</td>
			<td class="text-right">{{ $donation->amount or null }}</td>
		</tr> 

		<tr>
			<td colspan="4" class="text-right">
				Total Bill
			</td>
			<td class="text-right active">{{ $donation->amount or null }}</td>
		</tr>  
		<tr>
			<td colspan="4" class="text-right">
				Paid
			</td>
			<td class="text-right active">{{ $donation->amount or null }}</td>
		</tr>
		<tr>
			<td colspan="4" class="text-right">
				Due
			</td>
			<td class="text-right active">0.00</td>
		</tr>	
   </table>


<br>
<br>
<img src="{{asset('uploads/settings/paid-stamp.png')}}" alt="" class="img img-responsive">
<br>
<br>
Payment Date : {{ $donation->donate_date or null }}

@if(count($inbox_chats)>0)
<br>

	<table class="border">
		<caption>References</caption>
		<tr>
			<th style="width: 55%">Comments</th>
			<th style="width: 20%">From</th>
			<th style="width: 25%">Time</th>
		</tr>
		@foreach($inbox_chats as $key=>$inbox_chat)
		<tr>
			@if($inbox_chat->is_admin==0)
			<td>{{ $inbox_chat->comments or null }}</td>
			<td>{{ $inbox_chat->inbox->user->name or null }}</td>
			<td>{{ $inbox_chat->created_at or null }}</td>
			@else
			<td class="text-right active">{{ $inbox_chat->comments or null }}</td>
			<td class="active">Bidyanondo</td>
			<td class="active">{{ $inbox_chat->created_at or null }}</td>
			@endif
		</tr>  
		@endforeach
   </table>
@endif

</body>
</html>