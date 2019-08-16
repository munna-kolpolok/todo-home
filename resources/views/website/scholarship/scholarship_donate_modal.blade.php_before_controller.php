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
            //dynamic image load
            //var imageSrc = $(this).prev().prev().prev().val();
            //var base_url = $(this).prev().prev().val() + '/';
            //var image_src = base_url + imageSrc;
            //$('#donate-modal-image').attr('src', image_src);

            /*Load payment option*/
            const stdId = $(this).prev().val();
            $('.student_id').val(stdId);

            var bdt_min_donate_amount='<?php echo $currency_bdt->min_donate_amount?>';
            var bdt_max_donate_amount='<?php echo $currency_bdt->max_donate_amount?>';
            var usd_min_donate_amount='<?php echo $currency_usd->min_donate_amount?>';
            var usd_max_donate_amount='<?php echo $currency_usd->max_donate_amount?>';

            $.ajax({
                url: "{{url('get-scholarship-amount')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: stdId
                },
                success: function (response) {
                    var bd_amount = Math.ceil(response.bd);
                    var in_amount = Math.ceil(response.in);
                    var lang = response.lang;

                    //international payment option
                    const first_month_amount_in = Math.ceil(in_amount / 12);
                    const second_month_amount_in = Math.ceil((in_amount * 2) / 12);
                    const third_month_amount_in = Math.ceil((in_amount * 3) / 12);
                    const fifth_month_amount_in = Math.ceil((in_amount * 5) / 12);
                    const sixth_month_amount_in = Math.ceil((in_amount * 6) / 12);
                    const ninegth_month_amount_in = Math.ceil((in_amount * 9) / 12);
                    const tenth_month_amount_in = Math.ceil((in_amount * 10) / 12);
                    const twelve_month_amount_in = Math.ceil((in_amount * 12) / 12);

                    //BD payment option
                    const first_month_amount_bd = Math.ceil(bd_amount / 12);
                    const second_month_amount_bd = Math.ceil((bd_amount * 2) / 12);
                    const third_month_amount_bd = Math.ceil((bd_amount * 3) / 12);
                    const fifth_month_amount_bd = Math.ceil((bd_amount * 5) / 12);
                    const sixth_month_amount_bd = Math.ceil((bd_amount * 6) / 12);
                    const ninegth_month_amount_bd = Math.ceil((bd_amount * 9) / 12);
                    const tenth_month_amount_bd = Math.ceil((bd_amount * 10) / 12);
                    const twelve_month_amount_bd = Math.ceil((bd_amount * 12) / 12);

                    var international_content = `
                    <div class="row">
                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="first_month_in" value="${first_month_amount_in}" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> ${lang == 'bn' ? en2bnNumber(first_month_amount_in) : first_month_amount_in} (@lang('messages.Expense of one kid for one month'))</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_in" value="${third_month_amount_in}" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> ${lang == 'bn' ? en2bnNumber(third_month_amount_in) : third_month_amount_in} (@lang('messages.Expense of one kid for three months'))</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="six_month_in" value="${sixth_month_amount_in}" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> ${lang == 'bn' ? en2bnNumber(sixth_month_amount_in) : sixth_month_amount_in} (@lang('messages.Expense of one kid for six months'))</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="nine_month_in" value="${ninegth_month_amount_in}" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> ${lang == 'bn' ? en2bnNumber(ninegth_month_amount_in) : ninegth_month_amount_in} (@lang('messages.Expense of one kid for nine months'))</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="twelve_month_in" value="${twelve_month_amount_in}" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> ${lang == 'bn' ? en2bnNumber(twelve_month_amount_in) : twelve_month_amount_in} (@lang('messages.Expense of one kid for one year'))</label>
                       </div>
                       <div class="col-md-6">
                          <label class="radio-inline" style="display: block">
                               <input name="amount" id="custom_usd_r_scholarship" value="${usd_min_donate_amount}"
                               type="radio" onclick="custom_usd_scholarship_load(${usd_min_donate_amount})" />
                               <input class="custom_amount" id="custom_usd_scholarship" type="number" name="custom_amount" placeholder="@lang('messages.Custom Amount')" min="${usd_min_donate_amount}" max="${usd_max_donate_amount}" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                       </div>
                    </div>
                `;
                    //show in model
                    $('#amount-options-in').html(international_content);

                    var bd_content = `
                    <div class="row">
                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="first_month_bd" value="${first_month_amount_bd}" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> ${lang == 'bn' ? en2bnNumber(first_month_amount_bd) : first_month_amount_bd} (@lang('messages.Expense of one kid for one month'))</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_bd" value="${third_month_amount_bd}" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> ${lang == 'bn' ? en2bnNumber(third_month_amount_bd) : third_month_amount_bd} (@lang('messages.Expense of one kid for three months')) </label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="sixth_month_bd" value="${sixth_month_amount_bd}" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> ${lang == 'bn' ? en2bnNumber(sixth_month_amount_bd) : sixth_month_amount_bd} (@lang('messages.Expense of one kid for six months')) </label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="nine_month_bd" value="${ninegth_month_amount_bd}" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> ${lang == 'bn' ? en2bnNumber(ninegth_month_amount_bd) : ninegth_month_amount_bd} (@lang('messages.Expense of one kid for nine months')) </label>
                       </div>


                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="twelve_month_bd" value="${twelve_month_amount_bd}" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> ${lang == 'bn' ? en2bnNumber(twelve_month_amount_bd) : twelve_month_amount_bd} (@lang('messages.Expense of one kid for one year'))</label>
                       </div>
                       <div class="col-md-6">
                          <label class="radio-inline" style="display: block">
                               <input name="amount" id="custom_bdt_r_scholarship" value="${usd_min_donate_amount}"
                               type="radio" onclick="custom_bdt_scholarship_load(${usd_min_donate_amount})" />
                               <input class="custom_amount" id="custom_bdt_scholarship" type="number" name="custom_amount" placeholder="@lang('messages.Custom Amount')" min="${bdt_min_donate_amount}" max="${usd_max_donate_amount}" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                       </div>
                    </div>
                `;
                    //show in model
                    $('#amount-options-bd').html(bd_content);

                    

                    // $('.custom_amount').keyup(function () {
                    //     var rid = this.previousElementSibling.id;
                    //     $('#' + rid).prop("checked", true);
                    // });

                }
            });
        });
    });



    /* $('input[type="button"]').click(function (e) {
     var rid = this.previousElementSibling.id;
     $('#' + rid).prop("checked", true);
     })*/

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
@endpush