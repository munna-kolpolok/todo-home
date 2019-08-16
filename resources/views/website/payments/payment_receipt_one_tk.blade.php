<!DOCTYPE html>
<html>
<head>
	<title>Receipt</title>

	<style type="text/css">
		table.border,table.border td,table.border th {
		    border: 1px solid grey;
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
    @page {
      header: page-header;
      footer: page-footer;
    }
	</style>
</head>
<body>
	<?php
      $donation_reason=null;
      $v_currency=null;
      $v_amount=0;
      $no_unit=0;
      $donor_name=null;
      $donor_email=null;
      $payment_date=null;
      $donor_comments=null;

      if (request()->cookie('locale') == 'bn') {

          if($type==1)
          {
            //echo $type;die();
            $donation_slip_no=Lang::get('messages.Offline').' - '.App\Helpers\CommonHelper::en2bnNumber($payment->id);
            $v_amount=App\Helpers\CommonHelper::en2bnNumber(App\Helpers\CommonHelper::bd_money_format($payment->amount));
            $v_currency=$payment->currency_name;
            $payment_date=App\Helpers\CommonHelper::en2bnNumber(Carbon\Carbon::parse($payment->donate_date)->format('F d, Y'));

            $donation_reason=$payment->bn_project_name.' ('.$payment->bn_sector_name.' )';
            $donor_comments=$payment->donor_message;
          }
          else
          {

            if(isset($payment->order->food_project->name))
            {
              $donation_reason=$payment->order->food_project->bn_name.' ('.$payment->order->food_item->bn_name.')';
              $no_unit=$payment->order->no_unit;
              $bn_no_unit=App\Helpers\CommonHelper::en2bnNumber($payment->order->no_unit);
            }
            else if($payment->order->donate_plan>0)
            { 
              if($payment->order->donate_plan=='1')
              {
                $v_donation_type=Lang::get('messages.Sponsor_Monthly');
              }
              else if($payment->order->donate_plan=='6')
              {
                $v_donation_type=Lang::get('messages.Sponsor_Half_Yearly');
              }
              else if($payment->order->donate_plan=='12')
              {
                $v_donation_type=Lang::get('messages.Sponsor_Yearly');;
              }
              $donation_reason=$v_donation_type;
              $no_unit=$payment->order->no_unit;
              $bn_no_unit=App\Helpers\CommonHelper::en2bnNumber($payment->order->no_unit);
            }
            else
            {
              $donation_reason=$payment->project->bn_name;
            }

            if($type==2)
            {
              $v_amount=App\Helpers\CommonHelper::en2bnNumber(App\Helpers\CommonHelper::bd_money_format($payment->amount));
              $v_currency=Lang::get('messages.Dollar_USD');
              $payment_date=App\Helpers\CommonHelper::en2bnNumber(Carbon\Carbon::parse($payment->payment_date)->format('F d, Y'));
              $donation_slip_no=Lang::get('messages.Paypal').' - '.App\Helpers\CommonHelper::en2bnNumber($payment->id);
              $donor_comments=$payment->order->comments;

            }
            else if($type==3)
            {
              $v_amount=App\Helpers\CommonHelper::en2bnNumber(App\Helpers\CommonHelper::bd_money_format($payment->total_amount));
              $v_currency=Lang::get('messages.Taka_BDT');
              $payment_date=App\Helpers\CommonHelper::en2bnNumber(Carbon\Carbon::parse($payment->tran_time)->format('F d, Y'));
              $donation_slip_no=Lang::get('messages.SSL').' - '.App\Helpers\CommonHelper::en2bnNumber($payment->id);
              $donor_comments=$payment->order->comments;
            }

          }  
          

          $contact_address=$setting->bn_contact_address;
          $contact_no=App\Helpers\CommonHelper::en2bnNumber($setting->contact_no);
      }
      else
      {
      	//...........for english start....
          


          if($type==1)
          {
            //echo $type;die();
            $donation_slip_no='Offline - '.$payment->id;
            $v_amount=App\Helpers\CommonHelper::bd_money_format($payment->amount);
            $v_currency=$payment->currency_name;
            $payment_date=Carbon\Carbon::parse($payment->donate_date)->format('F d, Y');

            $donation_reason=$payment->project_name.' ('.$payment->sector_name.' )';
            $donor_comments=$payment->donor_message;
          }
          else
          {
            if(isset($payment->order->food_project->name))
            {
              $donation_reason=$payment->order->food_project->name.' ('.$payment->order->food_item->name.')';
              $no_unit=$payment->order->no_unit;
            }
            else if($payment->order->donate_plan>0)
            { 
              if($payment->order->donate_plan=='1')
              {
                $v_donation_type=Lang::get('messages.Sponsor_Monthly');
              }
              else if($payment->order->donate_plan=='6')
              {
                $v_donation_type=Lang::get('messages.Sponsor_Half_Yearly');
              }
              else if($payment->order->donate_plan=='12')
              {
                $v_donation_type=Lang::get('messages.Sponsor_Yearly');;
              }
              $donation_reason=$v_donation_type;
              $no_unit=$payment->order->no_unit;
            }
            else
            {
              $donation_reason=$payment->project->name;
            }

            if($type==2)
            {
              $v_amount=App\Helpers\CommonHelper::bd_money_format($payment->amount);
              $v_currency=Lang::get('messages.Dollar_USD');
              $payment_date=Carbon\Carbon::parse($payment->payment_date)->format('F d, Y');
              $donation_slip_no='Paypal - '.$payment->id;
              $donor_comments=$payment->order->comments;

            }
            else if($type==3)
            {
              $v_amount=App\Helpers\CommonHelper::bd_money_format($payment->total_amount);
              $v_currency=Lang::get('messages.Taka_BDT');
              $payment_date=Carbon\Carbon::parse($payment->tran_time)->format('F d, Y');
              $donation_slip_no='SSL - '.$payment->id;
              $donor_comments=$payment->order->comments;

            }

          }
          $contact_address=$setting->contact_address;
          $contact_no=$setting->contact_no;
      }


      if(isset($payment->user_id))
      {
        $donor_name=$payment->user->name;
        $donor_email=$payment->user->email;
      }
      else
      {
        if($type==1)
        {
            $donor_name=$payment->donor_name;
            $donor_email=$payment->email;
        }
        else if($type==2)
        {
            $donor_name=$payment->payer_first_name.' '.$payment->payer_last_name;
            $donor_email=$payment->payer_email;
        }
        else if($type==3)
        {
            $donor_name=$payment->cus_name;
            $donor_email=$payment->cus_email;
        }
        
      }
      
      ?>


	<div style="float: right;width: 100%;">
		
	
	<div style="float: left;width: 30%;">
	
		<p>@lang('messages.organization_name')</p>
		<p>{{ $contact_address }}</p>
		<p>{{ $contact_no }}</p>
		<p>{{ $setting->contact_email }}</p>
		
		
	</div>

	<div style="float: right;width: 48%;text-align: right">

		<img src="{{asset('site-assets/images/bidya_one.jpg')}}" alt="" class="img img-responsive">
		
	</div>
	</div>

  <img src="{{asset('site-assets/images/line_pdf.png')}}" alt="Bidyanondo" width="100%">


	<p style="text-align: right;">@lang('messages.Donation Slip No') : {{ $donation_slip_no }}</p>


<p>{{ $payment_date }}</p>
<p>@lang('messages.Dear Honorable Donor'),</p>
<p>@lang('messages.receipt_up')</p>
<br>
   <table class="border">
   	
   	<tr>
			<td>@lang('messages.Donation Amount')</td>
			<td class="active">{{ $v_amount }} {{ $v_currency }}</td>
		</tr>
		<tr>
			<td>@lang('messages.Donation Date')</td>
			<td>{{ $payment_date }}</td>
		</tr>
		<tr>
			<td>@lang('messages.Donor Name')</td>
			<td>{{ $donor_name or null }}</td>
		</tr>
		<tr>
			<td>@lang('messages.Donor Email')</td>
			<td>{{ $donor_email or null}}</td>
		</tr>
		<tr>
			<td>@lang('messages.Donation Description')</td>
			<td>{{ $donation_reason or null}}</td>
		</tr>
		@if($no_unit>0)
		<tr>
			<td>@lang('messages.No of plates/No of unit')</td>
			<td>@if(request()->cookie('locale') == 'bn')
                {{ $bn_no_unit }}
              @else
                {{ $no_unit }}
              @endif 
            </td>
		</tr>
		@endif

		@if(!empty($donor_comments))
		<tr>
			<td>@lang('messages.Comments')</td>
			<td>{{ $donor_comments or null}}</td>
		</tr>
		@endif


			
   </table>
<br>
<p>@lang('messages.receipt_down')</p>
<br>
<p>@lang('messages.receipt_down_2')</p>
<br>

<p>@lang('messages.Receipt Issue Date'): {{ $payment_date }}</p>
<p>@lang('messages.Issued By'): @lang('messages.organization_name')</p>
<br>
<br>
<p style="text-align: center;">@lang('messages.Thank You For Your Support')</p>

<htmlpagefooter name="page-footer">
  <img src="{{asset('site-assets/images/receipt_footer_pdf.png')}}" alt="Bidyanondo" width="100%">
</htmlpagefooter>

</body>
</html>