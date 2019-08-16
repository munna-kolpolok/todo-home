<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('website.layouts.htmlheader')
@show

<body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId : '589770344824887',
            autoLogAppEvents : true,
            xfbml : true,
            version : 'v2.11'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";;
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Your customer chat code -->
<div class="fb-customerchat"
	 attribution=setup_tool
	 page_id="159557731363880"
	 logged_in_greeting="Hi! How can we help you??"
	 logged_out_greeting="Hi! How can we help you??">
</div>

<!--Scroll Top-->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up" aria-hidden="true"></i>
</a>

<!-- start page-wrapper -->
<div class="page-wrapper home-style-two">

	<!-- start preloader -->
	<div class="preloader">
		<div class="middle">
			<i class="fi flaticon-animal"></i>
		</div>
	</div>
	<!-- end preloader -->

	<!-- Start header -->
	@include('website.layouts.header')
	<!-- end of header -->

	<!-- Dynamic content -->
	@yield('main-content')

	<!--Sigin and signup-->
	@include('website.layouts.sigin')

	<!--project common donate modal-->
	@include('website.layouts.project_donate_modal')

	<!-- start footer -->
	@include('website.layouts.footer')
	<!-- end footer -->

</div>
<!-- end of page-wrapper -->


@section('scripts')
	@include('website.layouts.scripts')
@show
</body>
</html>
