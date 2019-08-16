<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Bidyanondo is an education favorable voluntary organization founded by Kishor Kumar Das">
	<meta property="og:image" content="{{asset('site-assets/img/bidyanondo_logo2.jpg')}}" />

	<meta property="og:image:secure_url" content="secure.{{asset('site-assets/img/bidyanondo_logo2.jpg')}}" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="440" />
	<meta property="og:image:alt" content="Bidyanondo Logo" />

	<meta name="author" content="Kolpolok Limited">


	<!-- Page Title -->
	<title>Bidyanondo</title>

	<link rel="apple-touch-icon" sizes="60x60" href="{{asset('uploads/settings/favicon/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset($setting->favicon)}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset($setting->favicon2)}}">
	<link rel="manifest" href="{{asset('uploads/settings/favicon/site.webmanifest')}}">
	<link rel="mask-icon" href="{{asset('uploads/settings/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<!-- Icon fonts -->
	<link href="{{asset('site-assets/css/font-awesome.min.css')}}" rel="stylesheet">
	<link href="{{asset('site-assets/css/flaticon.css')}}" rel="stylesheet">

	<!-- Bootstrap core CSS -->
	<link href="{{asset('site-assets/css/bootstrap.min.css')}}" rel="stylesheet">

	<!-- Plugins for this template -->
	<link href="{{asset('site-assets/css/animate.css')}}" rel="stylesheet">
	

	<!-- Dynamic style added-->
	@stack('style')

	<!-- Custom styles for this template -->
	<link href="{{asset('site-assets/css/style.css')}}" rel="stylesheet">

	<!-- Custom style by rubel -->
	<link href="{{asset('site-assets/css/custom.css')}}" rel="stylesheet">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5c3826a6f51257001137a0d4&product=inline-share-buttons' async='async'></script>
</head>