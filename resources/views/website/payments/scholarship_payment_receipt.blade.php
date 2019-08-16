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
    // if(isset($inbox_id))
    // {
      $payments=DB::SELECT("SELECT d.id,d.`donate_date`,d.`amount`,c.currency_name,i.donor_message,s.name as sector_name,s.bn_name as bn_sector_name,p.name as project_name,p.bn_name as bn_project_name,u.name as donor_name,u.email,st.name as student_name,st.bn_name as bn_student_name,st.id_card 
                FROM `scholarship_donations` d
                inner join inboxes i on(i.id=d.inbox_id)
                inner join scholarships sh on(sh.id=d.scholarship_id)
                inner join students st on(st.id=sh.student_id)
                left join sectors s on(s.id=i.sector_id)
                left join projects p on(p.id=s.project_id)
                left join currencies c on(c.id=d.currency_id)
                left join users u on(u.id=d.user_id)
                WHERE d.`inbox_id`='$id'
                and d.`deleted_at` is null
                and i.`deleted_at` is null");

    // }
    // else
    // {
    //   $payment=DB::SELECT("SELECT d.id,d.`donate_date`,d.`amount`,c.currency_name,i.donor_message,s.name as sector_name,s.bn_name as bn_sector_name,p.name as project_name,p.bn_name as bn_project_name,u.name as donor_name,u.email 
    //             FROM `scholarship_donations` d
    //             inner join inboxes i on(i.id=d.inbox_id)
    //             left join sectors s on(s.id=i.sector_id)
    //             left join projects p on(p.id=s.project_id)
    //             left join currencies c on(c.id=d.currency_id)
    //             left join users u on(u.id=d.user_id)
    //             WHERE d.`id`='$id'
    //             and d.`deleted_at` is null
    //             and i.`deleted_at` is null")[0];
    // }
      


      $donation_reason=null;
      $v_currency=null;
      $v_amount=0;
      $sum_amount=0;
      $donor_name=null;
      $donor_email=null;
      $payment_date=null;
      $donor_comments=null;

      if (request()->cookie('locale') == 'bn') {

          foreach ($payments as $key => $payment) 
          {
            $donation_slip_no=Lang::get('messages.Offline-Sponsor').' - '.App\Helpers\CommonHelper::en2bnNumber($payment->id);
            
            $payment_date=App\Helpers\CommonHelper::en2bnNumber(Carbon\Carbon::parse($payment->donate_date)->format('F d, Y'));

            $donation_reason.=' '.$payment->bn_student_name.' ('.$payment->id_card.' ) ';
            $v_currency=$payment->currency_name;
            $donor_name=$payment->donor_name;
            $donor_email=$payment->email;
            $donor_comments=$payment->donor_message;
            $sum_amount+=$payment->amount;
          }
          $v_amount=App\Helpers\CommonHelper::en2bnNumber(App\Helpers\CommonHelper::bd_money_format($sum_amount));  

          $contact_address=$setting->bn_contact_address;
          $contact_no=App\Helpers\CommonHelper::en2bnNumber($setting->contact_no);
      }
      else
      {
      	//...........for english start....
          
            foreach ($payments as $key => $payment) {
              $donation_slip_no=Lang::get('messages.Offline-Sponsor').' - '.$payment->id;
              
              $payment_date=Carbon\Carbon::parse($payment->donate_date)->format('F d, Y');

              $donation_reason.=' '.$payment->student_name.' ('.$payment->id_card.' ) ';
              $v_currency=$payment->currency_name;
              $donor_name=$payment->donor_name;
              $donor_email=$payment->email;
              $donor_comments=$payment->donor_message;
              $sum_amount+=$payment->amount;
            }
            $v_amount=App\Helpers\CommonHelper::bd_money_format($sum_amount);
            
            
            
          
          $contact_address=$setting->contact_address;
          $contact_no=$setting->contact_no;
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

		<img src="{{asset('site-assets/images/bidya_pdf.png')}}" alt="" class="img img-responsive">
		
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