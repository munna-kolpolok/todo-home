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
			<th>Comments</th>
			<th>Bill ({{ $ssl_payment->currency or null }})</th>
		</tr>

		<tr>
			<td>{{ $ssl_payment->user->name or null }}</td>
			<td>{{ $ssl_payment->user->email or null }}</td>
			<td>SSL COMMERZ</td>
			<td>{{ $ssl_payment->order->comments or null }}</td>
			<td class="text-right">{{ $ssl_payment->total_amount or null }} Taka</td>
		</tr> 

		<tr>
			<td colspan="4" class="text-right">
				Total Bill
			</td>
			<td class="text-right active">{{ $ssl_payment->total_amount or null }} Taka</td>
		</tr>  
		<tr>
			<td colspan="4" class="text-right">
				Paid
			</td>
			<td class="text-right active">{{ $ssl_payment->total_amount or null }} Taka</td>
		</tr>
		<tr>
			<td colspan="4" class="text-right">
				Due
			</td>
			<td class="text-right active">0.00 Taka</td>
		</tr>	
   </table>


<br>
<br>
<img src="{{asset('uploads/settings/paid-stamp.png')}}" alt="" class="img img-responsive">
<br>
<br>
Payment Date : {{ $ssl_payment->tran_time or null }}
</body>
</html>