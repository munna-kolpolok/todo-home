<!DOCTYPE html>
<html>
<head>
	<title>Receipt</title>

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
			<th>Payment</th>
			<th>Student</th>
			<th>Bill</th>
		</tr>
		<?php $v_total=0;?>
		@foreach($scholarship_donations as $scholarship_donation)
		<tr>
			<td>{{ $scholarship_donation->user->name or null }}</td>
			<td>{{ $scholarship_donation->user->email or null }}</td>
			<td>
				@if($scholarship_donation->payment_method==1)
					Offline
				@else
					Online
				@endif
			</td>
			<td>{{ $scholarship_donation->scholarship->student->id_card or null }}</td>

			<td class="text-right">{{ $scholarship_donation->amount or null }} {{ $scholarship_donation->currency->currency_name or null }}</td>
			<?php $v_total+=$scholarship_donation->amount;
			$v_currency=$scholarship_donation->currency->currency_name;
			$v_donate_date=$scholarship_donation->donate_date;
			?>
		</tr> 
		@endforeach

		<tr>
			<td colspan="4" class="text-right">
				Total Bill
			</td>
			<td class="text-right active">{{ $v_total or null }} {{ $v_currency }}</td>
		</tr>  
		<tr>
			<td colspan="4" class="text-right">
				Paid
			</td>
			<td class="text-right active">{{ $v_total or null }} {{ $v_currency }}</td>
		</tr>
		<tr>
			<td colspan="4" class="text-right">
				Due
			</td>
			<td class="text-right active">0.00 {{ $v_currency }}</td>
		</tr>	
   </table>


<br>
<br>
<img src="{{asset('uploads/settings/paid-stamp.png')}}" alt="" class="img img-responsive">
<br>
<br>
Payment Date : {{ $v_donate_date or null }}
</body>
</html>