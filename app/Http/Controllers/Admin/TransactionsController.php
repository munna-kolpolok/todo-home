<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;

use Carbon\Carbon;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PDF;

use App\Models\Donation;
use App\Models\Paypal_Payment;
use App\Models\Ssl_Payment;
use App\Models\Website;
use App\Models\Sr_Project_Translation;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->menu_id = Menu::get('Transactions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess($this->menu_id)) {
            $endDate = Carbon::today()->format('d/m/Y');
            $startDate = Carbon::today()->subDay(7)->format('d/m/Y');
            $websites = Website::get();
            return View('admin.transaction.index', [
                'websites' => $websites,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        } else {
            return View('error');
        }
    }

    public function transactionDetail($type, $id)
    {
        //$inbox = (($type == 1) ? Inbox::find($id) : (($type == 2) ? Paypal_Payment::find($id) : Ssl_Payment::find($id)));
        $projectName = $sector = $student = $foodProjects = $foodItems = $donationPackage = $unitNo = $website = $ipAddress = $amount = $currency
            = $amountTk = $date = $transactionFee = $transactionType = $paymentMethod = $payerEmail = $donorAccount = $recipientAccount = $donor = $comments=$donation_type =$sr_project=$payer_name=$payer_contact_no='';
        if ($type == '1') {
            # Payment cash...
            $inbox = Donation::find($id);
            $projectName = $inbox->inbox->sector->project->name or null;
            $sector = $inbox->inbox->sector->name or null;
            $amount=CommonHelper::decimalNumberFormat($inbox->amount);
            $currency=$inbox->currency->currency_name .' ('.$inbox->currency->currency_code.')';
            $amountTk=CommonHelper::decimalNumberFormat($inbox->tk_amount);
            $date=CommonHelper::showDateTimeFormat($inbox->donate_date);
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
            $amount=CommonHelper::decimalNumberFormat($inbox->amount);
            $currency='Dollar (USD)';
            $amountTk=CommonHelper::decimalNumberFormat($inbox->tk_amount);

            $date=CommonHelper::showDateTimeFormat($inbox->payment_date);
            $transactionFee=CommonHelper::decimalNumberFormat($inbox->transaction_fee).' Dollar (USD)';
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
            $amount=CommonHelper::decimalNumberFormat($inbox->total_amount);
            $currency='Taka (BDT)';
            $amountTk=CommonHelper::decimalNumberFormat($inbox->total_amount);

            $date=CommonHelper::showDateTimeFormat($inbox->tran_time);
            $transactionFee=CommonHelper::decimalNumberFormat($inbox->total_amount-$inbox->store_amount).' Taka (BDT)';
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





       // dd($inbox);
        $transactionInfo = "<div class='row'>
                            <div class='col-md-6'>
                                <table class='table table-bordered'>
                                    <tbody>
                                    <tr>
                                        <td>Bidyanondo Project</td>
                                        <td>$projectName</td>
                                    </tr>
                                    <tr>
                                        <td>Sector</td>
                                        <td>$sector</td>
                                    </tr>
                                    <tr>
                                        <td>Students</td>
                                        <td>$student</td>
                                    </tr>
                                    <tr>
                                        <td>Food Project</td>
                                        <td>$foodProjects</td>
                                    </tr>
                                    <tr>
                                        <td>Food Items</td>
                                        <td>$foodItems</td>
                                    </tr>
                                    <tr>
                                        <td>Donation Package</td>
                                        <td>$donationPackage</td>
                                    </tr>
                                    <tr>
                                        <td>No of Plate/Unit no</td>
                                        <td>$unitNo</td>
                                    </tr>
                                    <tr>
                                        <td>Save Refugee Project</td>
                                        <td>$sr_project</td>
                                    </tr>
                                    
                                    <tr class='success'>
                                        <td>Website</td>
                                        <td>$website</td>
                                    </tr>
                                    <tr class='success'>
                                        <td>Donation Type</td>
                                        <td>$donation_type</td>
                                    </tr>
                                    <tr>
                                        <td>Ip Address</td>
                                        <td>$ipAddress</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class='col-md-6'>
                                <table class='table table-bordered'>
                                    <tbody>
                                    <tr class='success'>
                                        <td>Amount</td>
                                        <td>$amount $currency</td>
                                    </tr>
                                    <tr>
                                        <td>Amount(TK)</td>
                                        <td>$amountTk</td>
                                    </tr>
                                    <tr class='success'>
                                        <td>Date</td>
                                        <td>$date</td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Fee</td>
                                        <td>$transactionFee</td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>$transactionType</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Method</td>
                                        <td>$paymentMethod</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Donor's Account No</td>
                                        <td>$donorAccount</td>
                                    </tr>
                                    <tr>
                                        <td>Recipient Account No</td>
                                        <td>$recipientAccount</td>
                                    </tr>
                                    
                                    <tr class='warning'>
                                        <td>Payer Name</td>
                                        <td>$payer_name</td>
                                    </tr>
                                    <tr class='warning'>
                                        <td>Payer Email</td>
                                        <td>$payerEmail</td>
                                    </tr>
                                    <tr class='warning'>
                                        <td>Payer Contact No</td>
                                        <td>$payer_contact_no</td>
                                    </tr>

                                    <tr class='success'>
                                        <td>Donor</td>
                                        <td>$donor</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                           </div>";
        $embedMessage = !empty($comments) ? "<div id='message-box'>$comments</div>" : '';
        $data = ['transactionInfo' => $transactionInfo, 'message' => $embedMessage];
        return response()->json($data);
    }
    public function getInboxs(Request $request)
    {
        //dd($request->all());
        $type = $request->type;
        $website = $request->website_id;
        $limit = $request->length;
        $email = $request->email;
        $startoffset = $request->start;
        $typeStr ='';
        if(!empty($type))
        {
           if($type==4)
           {
               $typeStr ="AND a.type > '1'";
           }
           else
           {
               $typeStr ="AND a.type = '$type'";
           }
        }

        $websiteStr = empty($website) ? " " : "AND a.website_id = '$website'";
        $emailStr = empty($email) ? " " : "AND (a.email LIKE '%$email%' OR a.not_user_email LIKE '%$email%')";
        $startDate = !empty($request->startDate) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->startDate))) : '';
        $endDate = !empty($request->endDate) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->endDate))) : '';
        $limit_string = "LIMIT $startoffset,$limit";
        $list_values = TransactionsController::inboxesData($startDate, $endDate, $typeStr, $websiteStr, $limit_string, $emailStr);
        $total = TransactionsController::inboxesData($startDate, $endDate, $typeStr, $websiteStr, $limit_string, $emailStr, true);

        $data = [];
        if (count($list_values) > 0) {
            foreach ($list_values as $key => $row) {
                $downloadUrl = url(config('laraadmin.adminRoute')).'/transactions/download/'.$row->type.'/'.$row->id;
                $amount = CommonHelper::decimalNumberFormat($row->amount) . ' ' . $row->currency_name or null;
                $nestedData['seralNo'] = ++$key;
                $nestedData['donor'] = $row->email or null;
                $nestedData['Payment Email'] = $row->not_user_email or null;
                $nestedData['amount'] = "
                    <a class='transaction-details' data-toggle='modal' data-target='#modalCompose' onclick='loadTransactionDetails($row->type,$row->id)'> $amount </a>";
                $nestedData['date'] = CommonHelper::showDateTimeFormat($row->date);
                $nestedData['type'] = $row->type == 1 ? "<td class='danger'>Offline</td>" : "<td class='success'>Online</td>";
                $nestedData['Payment Method'] = $row->payment_name or null;

                $nestedData['website'] = $row->website_name or null;
                $nestedData['comments'] = str_limit($row->comments,10);
                
                $nestedData['action'] = "
                    <a class='transaction-details btn btn-success btn-xs' data-toggle='modal' data-target='#modalCompose' title='Details' onclick='loadTransactionDetails($row->type,$row->id)'> 
                           <i class='fa fa-eye'></i>
                     </a>
                     <a href='$downloadUrl' class='transaction-download btn btn-warning btn-xs' title='Details'> 
                           <i class='fa fa-download'></i>
                     </a>";
                $data[] = $nestedData;

            }
        }
        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => count($total),
            "recordsFiltered" => count($total),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    public static function inboxesData($startDate, $endDate, $typeStr, $websiteStr, $limit_string, $emailStr, $total = false)
    {
        if ($total) {
            $limit_string = "";
        }
        $list_values = DB::SELECT("select * from
            (
            SELECT d.id,d.`donate_date` as date,d.`amount`,c.currency_name,u.email,i.status,1 as type,i.`donor_message` as comments,i.attachment,i.`sector_id`,'1' as donate_way,s.name as sector_name,pm.name as payment_name,i.user_id,i.scholarship_amount,w.name as website_name, w.id as website_id,u.email as not_user_email
            FROM `donations` d 
            inner join inboxes i on(i.id=d.inbox_id)
            inner join websites w on(w.id=i.website_id)
            inner join currencies c on(c.id=d.currency_id)
            inner join sectors s on(s.id=i.sector_id)
            inner join users u on(u.id=d.user_id)
            inner join payment_methods pm on(pm.id=i.payment_method_id)
            where d.deleted_at is null
            and s.deleted_at is null
            and i.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null
            and w.deleted_at is null
            and pm.deleted_at is null
            union
            SELECT  p.`id`,p.payment_date as date,p.amount,'Dollar' as currency_name,u.email,'3' as status,'2' as type,o.comments,null as attachment,'1' as sector_id,p.`donate_way`,null as sector_name,'Paypal' as payment_name,p.user_id,p.scholarship_amount,w.name as website_name, w.id as website_id,p.payer_email as not_user_email
            FROM `paypal_payments` p
            inner join websites w on(w.id=p.website_id)
            inner join orders o on(o.id=p.order_id)
            left join users u on(u.id=p.user_id)
            where p.deleted_at is null
            and o.deleted_at is null
            and u.deleted_at is null
            and w.deleted_at is null
            UNION
            SELECT  s.`id`,s.`tran_time` as date,s.`total_amount` as amount,'Taka' as currency_name,u.email,'3' as status,'3' as type,o.comments,null as attachment,'1' as sector_id,s.`donate_way`,null as sector_name,'SSL' as payment_name,s.user_id,s.scholarship_amount,w.name as website_name, w.id as website_id,s.cus_email as not_user_email
                FROM `ssl_payments` s
                inner join websites w on(w.id=s.website_id)
                inner join orders o on(o.id=s.order_id)
                left join users u on(u.id=s.user_id)
                where s.`tran_status`='Success'
                and s.deleted_at is null
                and o.deleted_at is null
                and u.deleted_at is null
                and w.deleted_at is null
            ) a  
            WHERE (DATE(a.date) BETWEEN '$startDate' AND '$endDate') $typeStr $websiteStr $emailStr
            order by a.date desc $limit_string");

        return $list_values;
    }

    public function pdfDownload($type, $id)
    {
        $config=[
          'default_font_size' => '12'
        ];
        $data = [
            'type' =>$type,
            'id' =>$id,
        ];
        $mergeData = [];
        $pdf = PDF::loadView('admin.transaction.pdf_report', $data, $mergeData, $config);
        //return $pdf->stream('Receipt_'.$id.'.pdf');
        return $pdf->download('Transaction-' . $type . '-'.$id.'.pdf');
    }

}
