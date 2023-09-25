@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $categoryDetails['breadcambs']; ?></li>
        </ul>
        <h3> {{ $categoryDetails['catDetails']['category_name'] }}<small class="pull-right"> {{ count($categoryProducts) }}
                products are available </small></h3>
        <hr class="soft" />
        <p>
            {{ $categoryDetails['catDetails']['description'] }}
        </p>
        <hr class="soft" />
        @if (!isset($_REQUEST['search']))
        <form name="sortProducts" id="sortProducts" class="form-horizontal span6">
            <input type="hidden" name="url" id="url" value="{{ $url }}">
            <div class="control-group">
                <label class="control-label alignL">Sort By </label>
                <select name="sort" id="sort">
                    <option value="">Select</option>
                    <option value="product_latest" @if (isset($_GET['sort']) && $_GET['sort'] == 'product_latest') selected @endif>Latest Products
                    </option>
                    <option value="priduct_name_a_z">Priduct name A - Z</option>
                    <option value="priduct_name_z_a">Priduct name Z - A</option>
                    <option value="price_lowest">Lowest Price first</option>
                    <option value="price_highest">Highest Price first</option>
                </select>
            </div>
        </form>
        @endif
        <br class="clr" />
        <div class="tab-content filter_products">
            @include('front.products.ajax_products_listing')
        </div>
        {{-- <a href="compair.html" class="btn btn-large pull-right">Compair Product</a> --}}
        @if (!isset($_REQUEST['search']))
        <div class="pagination">
            @if (isset($_GET['sort']) && !empty($_GET['sort']))
                {{ $categoryProducts->appends(['sort' => $_GET['sort']])->links() }}
            @else
                {{ $categoryProducts->links() }}
            @endif
        </div>
        @endif
        <br class="clr" />
    </div>
@endsection
