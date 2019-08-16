@extends('la.layouts.app')

@section('htmlheader_title') @lang('messages.Dashboard') @endsection
@section('contentheader_title') @lang('messages.Dashboard') @endsection
@section('contentheader_description') Filter Payments <i class="fa fa-hand-o-right" aria-hidden="true" style="color: #E08E0B"></i>
 

    <div class="btn-group" role="group" aria-label="Basic example">
     
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/1') }}" @if($no_days=='1')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 24 hours</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/7') }}"  @if($no_days=='7')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 7 days</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/15') }}"  @if($no_days=='15')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 15 days</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/30') }}" @if($no_days=='30')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 30 days</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/90') }}" @if($no_days=='90')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 3 months</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/180') }}" @if($no_days=='180')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 6 months</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/270') }}" @if($no_days=='270')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 9 months</a>
      <a href="{{ url(config('laraadmin.adminRoute') . '/dashboard/365') }}" @if($no_days=='365')  class="btn btn-warning" @else class="btn btn-primary" @endif>Last 1 year</a>
     
    </div>


@endsection


@section('main-content')
<!-- Main content -->
  @la_access("Inboxes", "view")
  <?php 
  $bidya_w_online_total=$bidyanodo_paypal_payment+$bidyanodo_ssl_payment;
  $one_tk_online_total=$one_tk_w_p_payment+$one_tk_w_s_payment;

  $bidya_w_total=$bidyanodo_paypal_payment+$bidyanodo_ssl_payment+$bidyanodo_offline_payment;
  $one_tk_w_total=$one_tk_w_p_payment+$one_tk_w_s_payment+$one_tk_w_o_payment;
  $gift_me_w_total=$gift_me_w_p_payment+$gift_me_w_s_payment;

  $total_offline_payment=0;
  foreach($offline_payments as $offline_payment)
  {
    $total_offline_payment+=$offline_payment->offline_total_amount;
  }

  ?>
  <div class="row">

      

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{ $donor_count }}</h3>
            <p>@lang('messages.Donors')</p>
          </div>
          <div class="icon">
            <i class="fa fa-user-plus"></i>
          </div>
          <a href="{{ url(config('laraadmin.adminRoute') . '/users') }}" class="small-box-footer">@lang('messages.More info') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $student_count }}</h3>
            <p>@lang('messages.Students')</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="{{ url(config('laraadmin.adminRoute') . '/students') }}" class="small-box-footer">@lang('messages.More info') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ App\Helpers\CommonHelper::bd_money_format_wod($all_ssl_payment) }}</h3>
            <p>@lang('messages.SSL Payments')</p>
          </div>
          <div class="icon">
            <i class="fa fa-money"></i>
          </div>
          <a href="{{ url(config('laraadmin.adminRoute') . '/ssl_payments') }}" class="small-box-footer">@lang('messages.More info') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{ App\Helpers\CommonHelper::bd_money_format_wod($all_paypal_payment) }}</h3>
            <p>@lang('messages.Paypal Payments')</p>
          </div>
          <div class="icon">
            <i class="fa fa-paypal"></i>
          </div>
          <a href="{{ url(config('laraadmin.adminRoute') . '/paypal_payments') }}" class="small-box-footer">@lang('messages.More info') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>


  </div>


  <div class="row">
      

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ App\Helpers\CommonHelper::bd_money_format_wod($total_offline_payment) }}</h3>
            <p>@lang('messages.Offline Payments')</p>
          </div>
          <div class="icon">
            <i class="fa fa-check-square"></i>
          </div>
          <a href="{{ url(config('laraadmin.adminRoute') . '/donations') }}" class="small-box-footer">@lang('messages.More info') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_p_p_payment+$one_tk_p_s_payment) }}</h3>
            <p>1Taka Online Payment</p>
          </div>
          <div class="icon">
            <i class="fa fa-credit-card"></i>
          </div>
          <label class="small-box-footer">onetakameal & bidyanondo.org</label>
        </div>
      </div>

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_p_payment+$one_tk_w_s_payment) }}</h3>
            <p>1Taka Online Payment</p>
          </div>
          <div class="icon">
            <i class="fa fa-credit-card"></i>
          </div>
          <label class="small-box-footer">From onetakameal.org</label>
        </div>
      </div>

      <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{ App\Helpers\CommonHelper::bd_money_format_wod($sr_tk_w_p_payment) }}</h3>
            <p>Save Refugee Online Payment</p>
          </div>
          <div class="icon">
            <i class="fa fa-credit-card"></i>
          </div>
          <label class="small-box-footer">From savetherefugee.com</label>
        </div>
      </div>


  </div>

    <div class="row">
      <!-- Full system start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <!-- <i class="fa fa-money"></i> -->
              <h3 class="box-title">Gateway Wise Total Payments</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Payment Method</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Paypal Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($all_paypal_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>SSl Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($all_ssl_payment) }}</b></td>
                     </tr>
                     <tr class="success">
                       <td>Total Online Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($all_paypal_payment+$all_ssl_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>Offline Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($total_offline_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($all_paypal_payment+$all_ssl_payment+$total_offline_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- Full system end -->

      <!-- Full system website wise start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <!-- <i class="fa fa-money"></i> -->
              <h3 class="box-title">Website Wise Total Payments</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Website</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Bidyanondo</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidya_w_total) }}</b></td>
                     </tr>
                     <tr>
                       <td>One Taka Ahar</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_total) }}</b></td>
                     </tr>
                     <tr>
                       <td>Gift me</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($gift_me_w_total) }}</b></td>
                     </tr>
                     
                     <tr>
                       <td>Save The Refugee</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sr_tk_w_p_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidya_w_total+$one_tk_w_total+$gift_me_w_total+$sr_tk_w_p_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- Full system  website wise end -->

      <!-- Full system online website wise start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <!-- <i class="fa fa-money"></i> -->
              <h3 class="box-title">Website Wise Online Payments</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Website</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Bidyanondo</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidya_w_online_total) }}</b></td>
                     </tr>
                     <tr>
                       <td>One Taka Ahar</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_online_total) }}</b></td>
                     </tr>
                     <tr>
                       <td>Gift me</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($gift_me_w_total) }}</b></td>
                     </tr>
                     
                     <tr>
                       <td>Save The Refugee</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sr_tk_w_p_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidya_w_online_total+$one_tk_online_total+$gift_me_w_total+$sr_tk_w_p_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- Full system online website wise end -->

    </div>

    <div class="row">
      <!-- Bidyanondo start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-money"></i>
              <h3 class="box-title">Bidyanondo</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Payment Method</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Paypal Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidyanodo_paypal_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>SSl Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidyanodo_ssl_payment) }}</b></td>
                     </tr>
                     <tr class="success">
                       <td>Total Online Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidyanodo_paypal_payment+$bidyanodo_ssl_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>Offline Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidyanodo_offline_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($bidyanodo_paypal_payment+$bidyanodo_ssl_payment+$bidyanodo_offline_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- Bidyanondo end -->

      <!-- One Taka website start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-money"></i>
              <h3 class="box-title">One Taka Ahar</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Payment Method</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Paypal Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_p_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>SSl Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_s_payment) }}</b></td>
                     </tr>
                     <tr class="success">
                       <td>Total Online Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_p_payment+$one_tk_w_s_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>Offline Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_o_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_w_p_payment+$one_tk_w_s_payment+$one_tk_w_o_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- One Taka website end -->

      <!-- offline payments start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <!-- <i class="fa fa-money"></i> -->
              <h3 class="box-title">Website Wise Offline Payments</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Website</th>
                       <th>Amount (TK)</th>
                     </tr>
                     <?php $sum=0?>
                     @foreach($offline_payments as $offline_payment)
                     <tr>
                       <td>{{ $offline_payment->name or null }}</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($offline_payment->offline_total_amount) }}</b></td>
                     </tr>
                     <?php $sum+=$offline_payment->offline_total_amount?>
                     @endforeach
                     
                     <tr class="danger">
                       <td>Total</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sum) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- offline payments end -->

      


    </div>

    <div class="row">

      <!-- gift me website start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-money"></i>
              <h3 class="box-title">Gift me</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Payment Method</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Paypal Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($gift_me_w_p_payment) }}</b></td>
                     </tr>

                     <tr>
                       <td>SSL Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($gift_me_w_s_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($gift_me_w_total) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- gift me website end -->

      <!-- save the refugee website start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-money"></i>
              <h3 class="box-title">Save The Refugee</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Payment Method</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Paypal Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sr_tk_w_p_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sr_tk_w_p_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- save the refugee website end -->

      <!-- paypal payments start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-paypal"></i>
              <h3 class="box-title">Paypal Payments</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Website</th>
                       <th>Amount (TK)</th>
                     </tr>
                     <?php $sum=0?>
                     @foreach($paypal_payments as $paypal_payment)
                     <tr>
                       <td>{{ $paypal_payment->name or null }}</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($paypal_payment->paypal_total_amount) }}</b></td>
                     </tr>
                     <?php $sum+=$paypal_payment->paypal_total_amount?>
                     @endforeach
                     
                     <tr class="danger">
                       <td>Total</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sum) }}</b></td>
                     </tr>
                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- paypal payments end -->

      
    </div>


    <div class="row">
      <!-- ssl payments start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-money"></i>
              <h3 class="box-title">SSL Payments</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Website</th>
                       <th>Amount (TK)</th>
                     </tr>
                     <?php $sum=0?>
                     @foreach($ssl_payments as $ssl_payment)
                     <tr>
                       <td>{{ $ssl_payment->name or null }}</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($ssl_payment->ssl_total_amount) }}</b></td>
                     </tr>
                     <?php $sum+=$ssl_payment->ssl_total_amount?>
                     @endforeach
                     
                     <tr class="danger">
                       <td>Total</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($sum) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- ssl payments end -->
      {{-- 
      <!-- One Taka project start -->
      <div class="col-md-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-money"></i>
              <h3 class="box-title">One Taka Project(Bidya+1TK)</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /. tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div><!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-12">
                   <table class="table table-hover">
                     <tr>
                       <th>Payment Method</th>
                       <th>Amount (TK)</th>
                     </tr>

                     <tr>
                       <td>Paypal Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_p_p_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>SSl Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_p_s_payment) }}</b></td>
                     </tr>
                     <tr class="success">
                       <td>Total Online Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_p_p_payment+$one_tk_p_s_payment) }}</b></td>
                     </tr>
                     <tr>
                       <td>Offline Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_p_o_payment) }}</b></td>
                     </tr>
                     
                     <tr class="danger">
                       <td>Total Payments</td>
                       <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format_wod($one_tk_p_p_payment+$one_tk_p_s_payment+$one_tk_p_o_payment) }}</b></td>
                     </tr>


                   </table>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div>
          </div><!-- /.box -->
      </div>
      <!-- One Taka project end -->
      --}}
    </div>
    

    





  @endla_access



    {{-- 
        <section class="content">
          <!-- Small boxes (Stat box) -->
         
          <!-- Manpower Statistics of RAB Battalions End-->


          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                  <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                  <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
                  <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
                </ul>
                <div class="tab-content no-padding">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                </div>
              </div><!-- /.nav-tabs-custom -->

              <!-- Chat box -->
              <div class="box box-success">
                <div class="box-header">
                  <i class="fa fa-comments-o"></i>
                  <h3 class="box-title">Chat</h3>
                  <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                    <div class="btn-group" data-toggle="btn-toggle" >
                      <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i></button>
                      <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                    </div>
                  </div>
                </div>
                <div class="box-body chat" id="chat-box">
                  <!-- chat item -->
                  <div class="item">
                    <img src="{{asset('/la-assets/img/user4-128x128.jpg')}}" alt="user image" class="online">
                    <p class="message">
                      <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                        Mike Doe
                      </a>
                      I would like to meet you to discuss the latest news about
                      the arrival of the new theme. They say it is going to be one the
                      best themes on the market
                    </p>
                    <div class="attachment">
                      <h4>Attachments:</h4>
                      <p class="filename">
                        Theme-thumbnail-image.jpg
                      </p>
                      <div class="pull-right">
                        <button class="btn btn-primary btn-sm btn-flat">Open</button>
                      </div>
                    </div><!-- /.attachment -->
                  </div><!-- /.item -->
                  <!-- chat item -->
                  <div class="item">
                    <img src="{{asset('/la-assets/img/user3-128x128.jpg')}}" alt="user image" class="offline">
                    <p class="message">
                      <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
                        Alexander Pierce
                      </a>
                      I would like to meet you to discuss the latest news about
                      the arrival of the new theme. They say it is going to be one the
                      best themes on the market
                    </p>
                  </div><!-- /.item -->
                  <!-- chat item -->
                  <div class="item">
                    <img src="{{asset('/la-assets/img/user2-160x160.jpg')}}" alt="user image" class="offline">
                    <p class="message">
                      <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                        Susan Doe
                      </a>
                      I would like to meet you to discuss the latest news about
                      the arrival of the new theme. They say it is going to be one the
                      best themes on the market
                    </p>
                  </div><!-- /.item -->
                </div><!-- /.chat -->
                <div class="box-footer">
                  <div class="input-group">
                    <input class="form-control" placeholder="Type message...">
                    <div class="input-group-btn">
                      <button class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                </div>
              </div><!-- /.box (chat box) -->

              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">To Do List</h3>
                  <div class="box-tools pull-right">
                    <ul class="pagination pagination-sm inline">
                      <li><a href="#">&laquo;</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">&raquo;</a></li>
                    </ul>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="todo-list">
                    <li>
                      <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- checkbox -->
                      <input type="checkbox" value="" name="">
                      <!-- todo text -->
                      <span class="text">Design a nice theme</span>
                      <!-- Emphasis label -->
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name="">
                      <span class="text">Make the theme responsive</span>
                      <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name="">
                      <span class="text">Let theme shine like a star</span>
                      <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name="">
                      <span class="text">Let theme shine like a star</span>
                      <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name="">
                      <span class="text">Check your messages and notifications</span>
                      <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name="">
                      <span class="text">Let theme shine like a star</span>
                      <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                  <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                </div>
              </div><!-- /.box -->

              <!-- quick email widget -->
              <div class="box box-info">
                <div class="box-header">
                  <i class="fa fa-envelope"></i>
                  <h3 class="box-title">Quick Email</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div><!-- /. tools -->
                </div>
                <div class="box-body">
                  <form action="#" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" placeholder="Subject">
                    </div>
                    <div>
                      <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                  </form>
                </div>
                <div class="box-footer clearfix">
                  <button class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
              </div>

            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->

                  <i class="fa fa-map-marker"></i>
                  <h3 class="box-title">
                    Visitors
                  </h3>
                </div>
                <div class="box-body">
                  <div id="world-map" style="height: 250px; width: 100%;"></div>
                </div><!-- /.box-body-->
                <div class="box-footer no-border">
                  <div class="row">
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <div id="sparkline-1"></div>
                      <div class="knob-label">Visitors</div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <div id="sparkline-2"></div>
                      <div class="knob-label">Online</div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center">
                      <div id="sparkline-3"></div>
                      <div class="knob-label">Exists</div>
                    </div><!-- ./col -->
                  </div><!-- /.row -->
                </div>
              </div>
              <!-- /.box -->

              <!-- solid sales graph -->
              <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                  <i class="fa fa-th"></i>
                  <h3 class="box-title">Sales Graph</h3>
                  <div class="box-tools pull-right">
                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body border-radius-none">
                  <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div><!-- /.box-body -->
                <div class="box-footer no-border">
                  <div class="row">
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">
                      <div class="knob-label">Mail-Orders</div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">
                      <div class="knob-label">Online</div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">
                      <div class="knob-label">In-Store</div>
                    </div><!-- ./col -->
                  </div><!-- /.row -->
                </div><!-- /.box-footer -->
              </div><!-- /.box -->

              <!-- Calendar -->
              <div class="box box-solid bg-green-gradient">
                <div class="box-header">
                  <i class="fa fa-calendar"></i>
                  <h3 class="box-title">Calendar</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                      <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Add new event</a></li>
                        <li><a href="#">Clear events</a></li>
                        <li class="divider"></li>
                        <li><a href="#">View calendar</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div><!-- /.box-body -->
                <div class="box-footer text-black">
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- Progress bars -->
                      <div class="clearfix">
                        <span class="pull-left">Task #1</span>
                        <small class="pull-right">90%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                      </div>

                      <div class="clearfix">
                        <span class="pull-left">Task #2</span>
                        <small class="pull-right">70%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                      </div>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                      <div class="clearfix">
                        <span class="pull-left">Task #3</span>
                        <small class="pull-right">60%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                      </div>

                      <div class="clearfix">
                        <span class="pull-left">Task #4</span>
                        <small class="pull-right">40%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                      </div>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
              </div><!-- /.box -->

            </section><!-- right col -->
          </div><!-- /.row (main row) -->
         

        </section><!-- /.content -->

        --}}
@endsection

@push('styles')
{{--
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/morris/morris.css') }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/datepicker/datepicker3.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
--}}
@endpush


@push('scripts')
<!-- jQuery UI 1.11.4 -->
{{--
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
--}}

{{--
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('la-assets/plugins/morris/morris.min.js') }}"></script>


<!-- Sparkline -->
<script src="{{ asset('la-assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('la-assets/plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('la-assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('la-assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('la-assets/plugins/fastclick/fastclick.js') }}"></script>
--}}


<!-- dashboard -->
{{--
<script src="{{ asset('la-assets/js/pages/dashboard.js') }}"></script>
--}}
@endpush

@push('scripts')
<script>

</script>
@endpush