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
		.success {
			background-color: #CCC;
		}
		p { margin:0 }
	</style>
</head>
<body>

	<?php
	$projectName = $sector = $student = $foodProjects = $foodItems = $donationPackage = $unitNo = $website = $ipAddress = $amount = $currency
            = $amountTk = $date = $transactionFee = $transactionType = $paymentMethod = $payerEmail = $donorAccount = $recipientAccount = $donor = $comments=$donation_type =$sr_project=$payer_name=$payer_contact_no='';
        if ($type == '1') {
            # Payment cash...
            $inbox = App\Models\Donation::find($id);
            $projectName = $inbox->inbox->sector->project->name or null;
            $sector = $inbox->inbox->sector->name or null;
            $amount=App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount);
            $currency=$inbox->currency->currency_name .' ('.$inbox->currency->currency_code.')';
            $amountTk=App\Helpers\CommonHelper::decimalNumberFormat($inbox->tk_amount);
            $date=App\Helpers\CommonHelper::showDateTimeFormat($inbox->donate_date);
            $transactionType='Offline';
            $paymentMethod=$inbox->inbox->payment_method->name;
            $donorAccount=$inbox->inbox->payer_account_no;
            $recipientAccount=$inbox->inbox->payee_account_no;
            $payerEmail=$inbox->user->email;
            $donor=$inbox->user->email;
            $website=$inbox->inbox->website->name;
            $ipAddress=$inbox->inbox->created_ip_address;
            $donation_type='Project';
            $comments=$inbox->inbox->donor_message;
        } elseif ($type == '2') {
            # payment paypal...
            $inbox=DB::SELECT("SELECT p.payment_date,p.amount,p.tk_amount,p.transaction_fee,p.payer_email,p.payer_first_name,p.payer_last_name,p.payee_email,p.created_ip_address,p.sr_project_id,pr.name as project_name,s.id_card,fp.name as food_project_name,fi.name as food_item_name,o.no_unit,o.comments,w.name as website_name,u.email as donor_email,case 
                when p.`donate_way`=1 then 'General'
                when p.`donate_way`=2 then 'Project'
                when p.`donate_way`=3 then 'Sponsor'
                end as donation_type,
                case 
                when o.`donate_plan`=1 then 'Monthly'
                when o.`donate_plan`=6 then 'Half Yearly'
                when o.`donate_plan`=12 then 'Yearly'
                end as donate_plan

                FROM `paypal_payments` p
                inner join orders o on(p.order_id=o.id)
                inner join websites w on(p.website_id=w.id)
                left join food_projects fp on(o.food_project_id=fp.id)
                left join food_items fi on(o.food_item_id=fi.id)
                left join projects pr on(p.project_id=pr.id)
                
                left join students s on(p.student_id=s.id)
                left join users u on(p.user_id=u.id)
                WHERE p.id=$id
                and p.`deleted_at` is null
                and o.`deleted_at` is null
                and w.`deleted_at` is null
                and fp.`deleted_at` is null
                and fi.`deleted_at` is null
                and s.`deleted_at` is null
                and pr.`deleted_at` is null
                and u.`deleted_at` is null")[0];
            //$inbox = Paypal_Payment::find($id);
            $projectName = $inbox->project_name;

            $student = $inbox->id_card;
            $foodProjects = $inbox->food_project_name;
            $foodItems = $inbox->food_item_name;
            $donationPackage = $inbox->donate_plan;
            $amount=App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount);
            $currency='Dollar (USD)';
            $amountTk=App\Helpers\CommonHelper::decimalNumberFormat($inbox->tk_amount);

            $date=App\Helpers\CommonHelper::showDateTimeFormat($inbox->payment_date);
            $transactionFee=App\Helpers\CommonHelper::decimalNumberFormat($inbox->transaction_fee).' Dollar (USD)';
            $transactionType='Online';
            $paymentMethod='Paypal';
            $donorAccount=$inbox->payer_email;
            $recipientAccount=$inbox->payee_email;
            $payerEmail=$inbox->payer_email;
            $donor=$inbox->donor_email;
            $website=$inbox->website_name;
            $ipAddress=$inbox->created_ip_address;
            $comments=$inbox->comments;
            $donation_type=$inbox->donation_type;
            $payer_name=$inbox->payer_first_name.' '.$inbox->payer_last_name;

            if($inbox->no_unit>0)
            {
                $unitNo=$inbox->no_unit;
            }
            if($inbox->sr_project_id>0)
            {
               $sr_project=Sr_Project_Translation::where('sr_project_id',$inbox->sr_project_id)
               ->where('locale','en')
               ->first()->name; 
            }
            

        } elseif ($type == '3') {
            # payment sslcommerze...
            $inbox=DB::SELECT("SELECT p.tran_time,p.total_amount,p.store_amount,p.created_ip_address,pr.name as project_name,s.id_card,fp.name as food_project_name,fi.name as food_item_name,o.no_unit,o.comments,w.name as website_name,u.email as donor_email,case 
                when p.`donate_way`=1 then 'General'
                when p.`donate_way`=2 then 'Project'
                when p.`donate_way`=3 then 'Sponsor'
                end as donation_type,
                case 
                when o.`donate_plan`=1 then 'Monthly'
                when o.`donate_plan`=6 then 'Half Yearly'
                when o.`donate_plan`=12 then 'Yearly'
                end as donate_plan,p.cus_name,p.cus_email,p.cus_phone

                FROM `ssl_payments` p
                inner join orders o on(p.order_id=o.id)
                inner join websites w on(p.website_id=w.id)
                left join food_projects fp on(o.food_project_id=fp.id)
                left join food_items fi on(o.food_item_id=fi.id)
                left join projects pr on(p.project_id=pr.id)
                
                left join students s on(p.student_id=s.id)
                left join users u on(p.user_id=u.id)
                WHERE p.id=$id
                and p.`deleted_at` is null
                and o.`deleted_at` is null
                and w.`deleted_at` is null
                and fp.`deleted_at` is null
                and fi.`deleted_at` is null
                and s.`deleted_at` is null
                and pr.`deleted_at` is null
                and u.`deleted_at` is null")[0];
            //$inbox = Paypal_Payment::find($id);
            $projectName = $inbox->project_name;

            $student = $inbox->id_card;
            $foodProjects = $inbox->food_project_name;
            $foodItems = $inbox->food_item_name;
            $donationPackage = $inbox->donate_plan;
            $amount=App\Helpers\CommonHelper::decimalNumberFormat($inbox->total_amount);
            $currency='Taka (BDT)';
            $amountTk=App\Helpers\CommonHelper::decimalNumberFormat($inbox->total_amount);

            $date=App\Helpers\CommonHelper::showDateTimeFormat($inbox->tran_time);
            $transactionFee=App\Helpers\CommonHelper::decimalNumberFormat($inbox->total_amount-$inbox->store_amount).' Taka (BDT)';
            $transactionType='Online';
            $paymentMethod='SSL';
            $donorAccount='';
            $recipientAccount='';
            $donor=$inbox->donor_email;
            $website=$inbox->website_name;
            $ipAddress=$inbox->created_ip_address;
            $comments=$inbox->comments;
            $donation_type=$inbox->donation_type;
            $payer_name=$inbox->cus_name;
            $payerEmail=$inbox->cus_email;
            $payer_contact_no=$inbox->cus_phone;

            if($inbox->no_unit>0)
            {
                $unitNo=$inbox->no_unit;
            }
        }

	?>
	
	<div style="text-align: center">
		<h4>Transaction Details</h4>
	</div>
   

   <table class="border">
		<tr class='success'>
            <td>Amount</td>
            <td>{{ $amount }} {{ $currency }}</td>
        </tr>
        <tr>
            <td>Amount(TK)</td>
            <td>{{ $amountTk }}</td>
        </tr>
        <tr class='success'>
            <td>Date</td>
            <td>{{ $date }}</td>
        </tr>
        <tr>
            <td>Transaction Fee</td>
            <td>{{ $transactionFee }}</td>
        </tr>
        <tr>
            <td>Type</td>
            <td>{{ $transactionType }}</td>
        </tr>
        <tr>
            <td>Payment Method</td>
            <td>{{ $paymentMethod }}</td>
        </tr>
        
        <tr>
            <td>Donor's Account No</td>
            <td>{{ $donorAccount }}</td>
        </tr>
        <tr>
            <td>Recipient Account No</td>
            <td>{{ $recipientAccount }}</td>
        </tr>
        <tr class='success'>
            <td>Payer Name</td>
            <td>{{ $payer_name }}</td>
        </tr>
        <tr class='success'>
            <td>Payer Email</td>
            <td>{{ $payerEmail }}</td>
        </tr>
        <tr class='success'>
            <td>Payer Contact No</td>
            <td>{{ $payer_contact_no }}</td>
        </tr>
        <tr class='success'>
            <td>Donor</td>
            <td>{{ $donor }}</td>
        </tr>	
   </table>
   <br>
   <br>
   <table class='border'>
        <tbody>
        <tr>
            <td>Bidyanondo Project</td>
            <td>{{ $projectName }}</td>
        </tr>
        <tr>
            <td>Sector</td>
            <td>{{ $sector }}</td>
        </tr>
        <tr>
            <td>Students</td>
            <td>{{ $student }}</td>
        </tr>
        <tr>
            <td>Food Project</td>
            <td>{{ $foodProjects }}</td>
        </tr>
        <tr>
            <td>Food Items</td>
            <td>{{ $foodItems }}</td>
        </tr>
        <tr>
            <td>Donation Package</td>
            <td>{{ $donationPackage }}</td>
        </tr>
        <tr>
            <td>No of Plate/Unit no</td>
            <td>{{ $unitNo }}</td>
        </tr>
        <tr>
            <td>Save Refugee Project</td>
            <td>{{ $sr_project }}</td>
        </tr>
        
        <tr class='success'>
            <td>Website</td>
            <td>{{ $website }}</td>
        </tr>
        <tr class='success'>
            <td>Donation Type</td>
            <td>{{ $donation_type }}</td>
        </tr>
        <tr>
            <td>Ip Address</td>
            <td>{{ $ipAddress }}</td>
        </tr>
        </tbody>
   </table>


<br>
<br>



</body>
</html>