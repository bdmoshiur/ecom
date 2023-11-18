<?php
use App\CmsPage;
use App\Media;
$cmsUrls = CmsPage::select('url')->where('status',1)->get()->pluck('url')->toArray();
$medias = Media::where('status',1)->get();
?>
<div  id="footerSection">
	<div class="container">
		<div class="row">
			<div class="span3">
				<h5>ACCOUNT</h5>
				<a href="javascript:void(0)">YOUR ACCOUNT</a>
				<a href="javascript:void(0)">PERSONAL INFORMATION</a>
				<a href="{{ route('front.orders') }}">ORDER HISTORY</a>
			</div>
			<div class="span3">
				<h5>INFORMATION</h5>
                <a href="{{ route('front.contactus') }}">CONTACT US</a>
                @foreach ($cmsUrls as $url)
                    <a href="{{ route('cmspage.' . $url) }}">{{ strtoupper(str_replace('-', ' ', $url)) }}</a>
                @endforeach
			</div>
			<div class="span3">
				<h5>OUR OFFERS</h5>
				<a href="{{ route('front.new.product') }}">LATEST PRODUCTS</a>
				<a href="{{ route('front.top.sellers.product') }}">TOP SELLING PRODUCTS</a>
				<a href="javascript:void(0)">SPECIAL OFFERS</a>
			</div>
			<div id="socialMedia" class="span3 pull-right">
				<h5>SOCIAL MEDIA </h5>
                @foreach ($medias as $media)
                    <a target="_blank" href="<?php echo $media->link ?>"><img width="25" height="25" src="{{ asset('images/media_images/' . $media['image']) }}" title="{{ $media->name }}" alt="{{ $media->name }}"/></a>
                @endforeach
			</div>
		</div>
	</div><!-- Container End -->
</div>
