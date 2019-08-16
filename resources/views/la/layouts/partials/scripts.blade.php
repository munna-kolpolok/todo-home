<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('la-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('la-assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>


<!-- AdminLTE App -->
<script src="{{ asset('la-assets/js/app.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/stickytabs/jquery.stickytabs.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

{{--  
<script src="{{ asset('jquery-ui-1.12.1/jquery-ui.min.js') }}" type="text/javascript"></script>
--}}
<script src="{{ asset('jquery-confirm-v3.2.0/js/jquery-confirm.min.js') }}" type="text/javascript"></script>


<script src="{{ asset('js/commonJs.js') }}" type="text/javascript"></script>

{{-- 
<!-- Bangla keyboard -->
<script src="{{ asset('js/driver.phonetic.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/driver.probhat.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/engine.js') }}" type="text/javascript"></script>
--}}

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->


<script type="text/javascript">

	$(function () {
	    $.ajaxSetup({
  		    headers: {
  		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		    }
  		});
      //.......for bangla input start.........
      // $(".bangla").bnKb({
      //   'switchkey': {"webkit":"k","mozilla":"y","safari":"k","chrome":"k","msie":"y"},
      //   'driver': phonetic
      // });
      //.......for bangla input end.........

       var url = window.location.href; //get curent page url
       var url1 = (url.substring(0, url.lastIndexOf('/')));
       var url2 = (url1.substring(0, url1.lastIndexOf('/')));
       var url3 = (url2.substring(0, url2.lastIndexOf('/')));
          $(".treeview-menu a").each(function() { 
            if ( (this.href) == url || (this.href) == url1 || (this.href) == url2 || (this.href) == url3) {
                   $(this).parent().addClass("active"); //add active class to matched anchor parent li
                   $(this).parent().parent().addClass("menu-open"); //add menu-open class to matched anchor parent ul
                   $(this).parent().parent().css("display","block"); //add css "display":"block" to matched anchor parent ul
                   $(this).parent().parent().parent().addClass("active"); //add active class to matched anchor parent ul parent li
            }
        });

        $('.sidebar-toggle').on('click',function () {
            $('#example1').css('width', '100%');
        })



          // $('.confirm').confirm({
          //   title: 'Confirm!',
          //     content: "Are you sure to Delete this ?",
          //     buttons: {
          //         yes: function () {
          //           var formid = $('form').attr('id');
          //           alert(formid);
          //             $('#'+formid ).submit();
          //         },
          //         close: function () {
          //         }
          //     }
          // });

          // $(".alert").delay(4000).slideUp(200, function() {
          //     $(this).alert('close');
          // });


  });

</script>
@stack('scripts')