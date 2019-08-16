<!-- Modal -->
<div class="modal fade donate-modal" id="donate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content scholarship-modal">
            <!--Common modal-->
             @include('website.layouts.common_modal_header')

            <div class="modal-body">
                <div class="modal-padding-md">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="donate-client">
                                    <div id="account-tab">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-justified">
                                            <li class="active">
                                                <a class="nav-link" data-toggle="tab" href="#bdt">
                                                    <span>৳</span>
                                                    @lang('messages.BDT')
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#usd">
                                                    <i class="fa fa-usd"></i>
                                                    @lang('messages.USD')
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div id="usd" class="tab-pane fade">
                                                <div class="amount">
                                                    <form method="POST" id="payment-form-in"
                                                          role="form" action="{{url('/pay_with_paypal')}}" onsubmit="return validatePaypalScholarshipForm();" target="_blank">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="student_id" class="student_id">
                                                        <input type="hidden" name="donate_way" value="3">
                                                        <input type="hidden" class="user_id" name="user_id" value="">

                                                        <div id="amount-options-in"></div>

                                                        <div class="loading">
                                                            <label><i class="fa fa-spinner fa-5x fa-spin" aria-hidden="true"></i></label>
                                                        </div>

                                                        <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                                <textarea type="text"  name="comments" class="form-control comments" placeholder="@lang('messages.Comments here')" id="sponsor_p_comments"></textarea>
                                                        </div>


                                                        <div class="payment-button">
                                                            <!-- <input type="hidden" id="paypal_min_donate_amount_s" value="{{ $currency_usd->min_donate_amount }}"> -->

                                                            <button type="submit" class="btn theme-btn btn-block paypal_btn">
                                                                <i class="fa fa-paypal" style="color: #fff"
                                                                   aria-hidden="true"></i>
                                                                @lang('messages.Paywith Paypal') &#47; @lang('messages.Credit Card')
                                                            </button>
                                                        </div>

                                                        @include('website.layouts.donate_ssl_button')
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="bdt" class="tab-pane active">
                                                <div class="buy-wrapper">
                                                    <div class="amount">
                                                        <form method="POST" id="payment-form-bd"
                                                              role="form" action="{{url('/donation_confirmation')}}" onsubmit="return validateSslScholarshipForm();"  target="_blank">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="student_id" class="student_id">
                                                            <input type="hidden" name="donate_way" value="3">
                                                            <input type="hidden" class="user_id" name="user_id" value="">

                                                            <div id="amount-options-bd"></div>

                                                            <div class="loading">
                                                                <label><i class="fa fa-spinner fa-5x fa-spin" aria-hidden="true"></i></label>
                                                            </div>

                                                            <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                                <textarea type="text"  name="comments" class="form-control comments" placeholder="@lang('messages.Comments here')" id="sponsor_s_comments"></textarea>
                                                        </div>

                                                            <div class="payment-button">
                                                             
                                                                <button type="submit"
                                                                        class="btn theme-btn btn-block ssl_btn">
                                                                    <i class="fa fa-money"></i> @lang('messages.Pay with card/bKash')
                                                                </button>


                                                            </div>

                                                            @include('website.layouts.donate_ssl_button')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    function en2bnNumber(number) {
        var retStr = number.toString();
        var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        for (var x in finalEnlishToBanglaNumber) {
            retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
        }
        return retStr;
    }

    $(function(){
        //add a single handler to the parent instead of per button
        $('.donate').on('click',function(){
            /*Load payment option*/
            const stdId = $(this).prev().val();
            $('.student_id').val(stdId);
            $('#amount-options-in').empty();
            $('#amount-options-bd').empty();
            $.ajax({
                url: "{{url('get-scholarship-amount')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: stdId
                },
                beforeSend: function(){
                    $(".loading").show();
                },
                complete: function(){
                    $(".loading").hide();
                },
                success: function (data) {
                    //show in model
                    $('#amount-options-in').html(data.international_content);
                    $('#amount-options-bd').html(data.bd_content);
                }
            });
        });
    });
</script>


  @if(request()->cookie('locale') == 'bn')
  <script>
      //...........scholarship donate pop up start...........
      function custom_bdt_scholarship_load(min_amount)
      {
          $("#custom_bdt_scholarship").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is').' '. \App\Helpers\CommonHelper::en2bnNumber($currency_bdt->min_donate_amount).' '. Lang::get('messages.Taka')?>");
          $(".bdt_radio_scholarship").removeAttr('checked');
      }
      function bdt_scholarship_load()
      {
          $("#custom_bdt_scholarship").val('');
          $("#custom_bdt_r_scholarship").removeAttr('checked');
      }
      function custom_usd_scholarship_load(min_amount)
      {
          $("#custom_usd_scholarship").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is').' '. \App\Helpers\CommonHelper::en2bnNumber($currency_usd->min_donate_amount).' '. Lang::get('messages.Dollar')?>");
          $(".usd_radio_scholarship").removeAttr('checked');
      }
      function usd_scholarship_load()
      {
          $("#custom_usd_scholarship").val('');
          $("#custom_usd_r_scholarship").removeAttr('checked');
      }
      //...........scholarship donate pop up end...........
  </script>
  @else
  <script>
      //...........scholarship donate pop up start...........
      function custom_bdt_scholarship_load(min_amount)
      {
          $("#custom_bdt_scholarship").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is')?> "+min_amount+ " <?php echo Lang::get('messages.Taka')?>");
          $(".bdt_radio_scholarship").removeAttr('checked');
      }
      function bdt_scholarship_load()
      {
          $("#custom_bdt_scholarship").val('');
          $("#custom_bdt_r_scholarship").removeAttr('checked');
      }
      function custom_usd_scholarship_load(min_amount)
      {
          $("#custom_usd_scholarship").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is')?> "+min_amount+ " <?php echo Lang::get('messages.Dollar')?>");
          $(".usd_radio_scholarship").removeAttr('checked');
      }
      function usd_scholarship_load()
      {
          $("#custom_usd_scholarship").val('');
          $("#custom_usd_r_scholarship").removeAttr('checked');
      }
      //...........scholarship donate pop up end...........
  </script>
  @endif

@endpush
