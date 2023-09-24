<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    @if (!empty($meta_title))
        <title>{{ $meta_title }}</title>
    @else
        <title>online Shopping</title>
    @endif

    @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @else
        <meta name="description" content="this is the ecomerce website description">
    @endif


    @if (!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @else
        <meta name="keywords" content="this is the ecomerce website keywords">
    @endif

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Front style -->
	<link id="callCss" rel="stylesheet" href="{{ asset('css/front_css') }}/front.min.css" media="screen"/>
	<link href="{{ asset('css/front_css') }}/base.css" rel="stylesheet" media="screen"/>
	<!-- Front style responsive -->
	<link href="{{ asset('css/front_css') }}/front-responsive.min.css" rel="stylesheet"/>
	<link href="{{ asset('css/front_css') }}/font-awesome.css" rel="stylesheet" type="text/css">
	<!-- Google-code-prettify -->
	<link href="{{ asset('js/front_js') }}/google-code-prettify/prettify.css" rel="stylesheet"/>
    <link href="{{ url('plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet"/>
	<!-- fav and touch icons -->
	<link rel="shortcut icon" href="{{ asset('images/front_images') }}/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images') }}/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images') }}/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images') }}/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images') }}/ico/apple-touch-icon-57-precomposed.png">
	<style type="text/css" id="enject"></style>
    <style>
        form.cmxform label.error, label.error {
            /* remove the next line when you have trouble in IE6 with labels in list */
            color: red;
            font-style: italic
        }
    </style>

    <!-- BEGIN SHAREAHOLIC CODE -->
<link rel="preload" href="https://cdn.shareaholic.net/assets/pub/shareaholic.js" as="script" />
<meta name="shareaholic:site_id" content="27cc7b6af6cbdb82bb9240784f1bf4e6" />
<script data-cfasync="false" async src="https://cdn.shareaholic.net/assets/pub/shareaholic.js"></script>
<!-- END SHAREAHOLIC CODE -->

<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=64fddb62d0137a0012e89d6a&product=inline-share-buttons&source=platform" async="async"></script>

</head>
<body>
@include('layouts.front_layout.front_header')
<!-- Header End====================================================================== -->
@include('front.banners.home_page_banner')
<div id="mainBody">
	<div class="container">
		<div class="row">
			<!-- Sidebar ================================================== -->
			@include('layouts.front_layout.front_sidebar')
			<!-- Sidebar end=============================================== -->
			@yield('content')
		</div>
	</div>
</div>
<!-- Footer ================================================================== -->
@include('layouts.front_layout.front_footer')
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="{{ asset('js/front_js') }}/jquery.js" type="text/javascript"></script>
<script src="{{ asset('js/front_js') }}/jquery.validate.js" type="text/javascript"></script>
<script src="{{ asset('js/front_js') }}/front.min.js" type="text/javascript"></script>
<script src="{{ asset('js/front_js') }}/google-code-prettify/prettify.js"></script>

<script src="{{ asset('js/front_js') }}/front.js"></script>
<script src="{{ asset('js/front_js') }}/front_script.js"></script>
<script src="{{ asset('js/front_js') }}/jquery.lightbox-0.5.js"></script>
<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>

<script>
    $(function() {
        $('.textarea').summernote();
    });

</script>

</body>
</html>
