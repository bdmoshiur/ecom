<?php
use App\CmsPage;
$cmsUrls = CmsPage::select('url')->where('status',1)->get()->pluck('url')->toArray();
?>
<div  id="footerSection">
	<div class="container">
		<div class="row">
			<div class="span3">
				<h5>ACCOUNT</h5>
				<a href="login.html">YOUR ACCOUNT</a>
				<a href="login.html">PERSONAL INFORMATION</a>
				<a href="login.html">ORDER HISTORY</a>
			</div>
			<div class="span3">
				<h5>INFORMATION</h5>
				{{-- <a href="{{ route('cmspage.about-us') }}">ABOUT US</a --}}
				{{-- <a href="">TERMS AND CONDITIONS</a>
                <a href="">CONTACT US</a>
				<a href="">FAQ</a> --}}
                @foreach ($cmsUrls as $url)
                    <a href="{{ route('cmspage.' . $url) }}">{{ strtoupper(str_replace('-', ' ', $url)) }}</a>
                @endforeach
			</div>
			<div class="span3">
				<h5>OUR OFFERS</h5>
				<a href="#">NEW PRODUCTS</a>
				<a href="#">TOP SELLERS</a>
				<a href="special_offer.html">SPECIAL OFFERS</a>
			</div>
			<div id="socialMedia" class="span3 pull-right">
				<h5>SOCIAL MEDIA </h5>
				<a href="https://www.facebook.com/groups/stackdevelopers"><img width="60" height="60" src="{{ asset('images/front_images') }}/facebook.png" title="facebook" alt="facebook"/></a>
				<a href="#"><img width="60" height="60" src="{{ asset('images/front_images') }}/twitter.png" title="twitter" alt="twitter"/></a>
				<a href="https://www.youtube.com/StackDevelopers"><img width="60" height="60" src="{{ asset('images/front_images') }}/youtube.png" title="youtube" alt="youtube"/></a>
			</div>
		</div>
		<p class="pull-right"><a target="_blank" href="https://www.youtube.com/StackDevelopers">&copy; Moshiur Rahman</a></p>
	</div><!-- Container End -->
</div>
