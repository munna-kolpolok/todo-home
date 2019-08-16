<!-- All JavaScript files
================================================== -->
<script src="{{asset('site-assets/js/jquery.min.js')}}"></script>
<script src="{{asset('site-assets/js/bootstrap.min.js')}}"></script>

<!-- Plugins for this template -->
<script src="{{asset('site-assets/js/jquery-plugin-collection.js')}}"></script>

<!-- Custom script for this template -->
<script src="{{asset('site-assets/js/script.js')}}"></script>

@stack('scripts')

<!-- Tab scripts -->
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        //............Donate button submit start............
        $('#g_s_form').submit(function() {
            
           $('#donate-simple-modal').modal('hide');
           
           //location.reload(true);
           return true;

           //window.location.reload();
           // $(".ssl_btn").hide();
           // $(".ssl_btn_processing").show();
           //return true;
        });
        $('#g_p_form').submit(function() {
           $('#donate-simple-modal').modal('hide');
           //location.reload(true);
           // $(".paypal_btn").hide();
           // $(".paypal_btn_processing").show();
           return true;
        });

        $('#p_s_form').submit(function() {
            $('#donate-project-modal').modal('hide');
            //location.reload(true);
           // $(".ssl_btn").hide();
           // $(".ssl_btn_processing").show();
           return true;
        });
        $('#p_p_form').submit(function() {
            $('#donate-project-modal').modal('hide');
            //location.reload(true);

           // $(".paypal_btn").hide();
           // $(".paypal_btn_processing").show();
           return true;
        });

        $('#payment-form-bd').submit(function() {
            $('#donate-modal').modal('hide');
            //location.reload(true);
            
           // $(".ssl_btn").hide();
           // $(".ssl_btn_processing").show();
           return true;
        });
        $('#payment-form-in').submit(function() {
            $('#donate-modal').modal('hide');
            //location.reload(true);

           // $(".paypal_btn").hide();
           // $(".paypal_btn_processing").show();
           return true;
        });
        //............Donate button submit end............
        

    });

    /*Scroll top start*/
    // ===== Scroll to Top ====
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });
    /*Scroll top end*/

    /*Animated menu*/
    /*$('header #navbar li.sub-menu ul li a').hover(function () {
     $(this).addClass('wow bounceInDown');
     });*/
   /* var baseMargin = 20;
    $('header #navbar li.sub-menu ul li a').on('mouseenter', function (e) {
        $(this).stop().animate(function () {
            $(this).css({fontSize : 50})
        }, 500);
    })
        .on('mouseout', function (e) {
            //$(this).stop().animate({marginTop: (baseMargin - 20) + 'px'}, 500);
        });*/

    // $(".nav-tabs a").click(function(){
    //     $(this).tab('show');
    // });

    /*When click donate button*/
    $('.donate-project').click(function (e) {
        var parentLocation = this.parentNode.children;

        var project_id = parentLocation[0].id;
        //var srcSmileImageIs = parentLocation[1].id;
        var project_name_id = parentLocation[2].id;

        var project_id = $('#' + project_id).val();
        //var imageSrc = $('#' + srcSmileImageIs).val();
        var project_name = $('#' + project_name_id).val();

        $('.project_id').val(project_id);
        $('#project_name_id').text(project_name);

       /* var base_url = $('#base_url').val() + '/';
        var image_src = base_url + imageSrc;
        $('#donate-modal-image').attr('src', image_src);*/
    });

    /*
    $('.ssl_btn').click(function (e) {
        var parentLocation = this.parentNode.children;
        //console.log(parentLocation);
        var project_id = parentLocation[0].id;
        //var srcSmileImageIs = parentLocation[1].id;
        //var project_name_id = parentLocation[2].id;
    });
    */


    function paypalSubmitBtn() {
        $(".paypal_btn").hide();
        $(".paypal_btn_processing").show();
    }

    //...........Paypal Button start...............
    function validatePaypalGeneralForm()
    {
        var user_id = localStorage.getItem('kolpo_bidya_ahar_m');
        $('.user_id').val(user_id);

        // var data= $('#g_p_comments').val() ;
        // var dataFull = data.replace(/[^\w\s]/gi, '');
        // $('#g_p_comments' ).val(dataFull);
        return true;
    }
    function validatePaypalProjectForm()
    {
        var user_id = localStorage.getItem('kolpo_bidya_ahar_m');
        $('.user_id').val(user_id);

        // var data= $('#p_p_comments').val() ;
        // var dataFull = data.replace(/[^\w\s]/gi, '');
        // $('#p_p_comments' ).val(dataFull);
        return true;
    }
    function validatePaypalScholarshipForm()
    {
        var user_id = localStorage.getItem('kolpo_bidya_ahar_m');
        $('.user_id').val(user_id);

        // var data= $('#sponsor_p_comments').val() ;
        // var dataFull = data.replace(/[^\w\s]/gi, '');
        // $('#sponsor_p_comments').val(dataFull);
        return true;
    }
    //...........Paypal Button end...............

    //...........SSL Button start...............
    function validateSslGeneralForm()
    {
        var user_id = localStorage.getItem('kolpo_bidya_ahar_m');
        $('.user_id').val(user_id);

        // var data= $('#g_s_comments').val() ;
        // var dataFull = data.replace(/[^\w\s]/gi, '');
        // $('#g_s_comments' ).val(dataFull);
        return true;
    }
    function validateSslProjectForm()
    {
        var user_id = localStorage.getItem('kolpo_bidya_ahar_m');
        $('.user_id').val(user_id);

        // var data= $('#p_s_comments').val() ;
        // var dataFull = data.replace(/[^\w\s]/gi, '');
        // $('#p_s_comments' ).val(dataFull);
        return true;
    }

    function validateSslScholarshipForm()
    {
        var user_id = localStorage.getItem('kolpo_bidya_ahar_m');
        $('.user_id').val(user_id);

        // var data= $('#sponsor_s_comments').val() ;
        // var dataFull = data.replace(/[^\w\s]/gi, '');
        // $('#sponsor_s_comments' ).val(dataFull);
        return true;
    }
    //...........SSL Button end...............


    
    


</script>