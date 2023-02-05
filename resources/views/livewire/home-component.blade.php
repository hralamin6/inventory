<main class="main" x-data="{ activeSlide: 1, slides: 1 }" x-init="window.setInterval(function(){
                 if(slides=={{$products->count()}}){
                 slides=1
                 }else{slides+=1}
                }, 5000)">
    <section class="home-slider position-relative pt-50">
        <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
            @foreach($products as $key=> $product)

            <div x-cloak x-show="slides=={{$key+1}}"  class="single-hero-slider single-animation-wrap">
                <div class="container">
                    <div class="row align-items-center slider-animated-1">
                        <div class="col-lg-5 col-md-6">
                            <div class="hero-slider-content-2 capitalize">
                                <h4 class="animated">{{$product->category->name}}</h4>
                                <h2 class="animated fw-900">{{$product->name}}</h2>
                                <h1 class="animated fw-900 text-brand">{{$product->regular_price}}</h1>
                                <p class="animated">{{$product->overview}}</p>
                                <a class="animated btn btn-brush btn-brush-3" href="product-details.html"> @lang('buy now') </a>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="single-slider-img single-slider-img-1">
                                <img class="animated slider-1-1" src="{{$product->getFirstMediaURl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';" alt="">
{{--                                <img class="animated slider-1-1" src="{{asset('assets/imgs/slider/slider-1.png')}}" alt="">--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="slider-arrow hero-slider-1-arrow">
            <span x-on:click="if(slides>1)slides-=1" class="slider-btn slider-prev slick-arrow" style=""><i class="fi-rs-angle-left"></i></span>
            <span x-on:click="if(slides<{{$products->count()}})slides+=1" class="slider-btn slider-next slick-arrow" style=""><i class="fi-rs-angle-right"></i></span>
        </div>
    </section>
    <section class="featured section-padding position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{asset('assets/imgs/theme/icons/feature-1.png')}}" alt="">
                        <h4 class="bg-1">Free Shipping</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{asset('assets/imgs/theme/icons/feature-2.png')}}" alt="">
                        <h4 class="bg-3">Online Order</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{asset('assets/imgs/theme/icons/feature-3.png')}}" alt="">
                        <h4 class="bg-2">Save Money</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{asset('assets/imgs/theme/icons/feature-4.png')}}" alt="">
                        <h4 class="bg-4">Promotions</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{asset('assets/imgs/theme/icons/feature-5.png')}}" alt="">
                        <h4 class="bg-5">Happy Sell</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="{{asset('assets/imgs/theme/icons/feature-6.png')}}" alt="">
                        <h4 class="bg-6">24/7 Support</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-tabs section-padding position-relative wow fadeIn animated">
        <div class="bg-square"></div>
        <div class="container">
            <div class="tab-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two" type="button" role="tab" aria-controls="tab-two" aria-selected="false">Popular</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three" type="button" role="tab" aria-controls="tab-three" aria-selected="false">New added</button>
                    </li>
                </ul>
                <a href="#" class="view-more d-none d-md-flex">View More<i class="fi-rs-angle-double-small-right"></i></a>
            </div>
            <!--End nav-tabs-->
            <div class="tab-content wow fadeIn animated" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">
                        @foreach($items as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="product-details.html">
                                            <img class="default-img" src="{{$item->getFirstMediaURl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';" alt="">
                                            <img class="hover-img" src="{{$item->getFirstMediaURl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';" alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="wishlist.php"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn hover-up" href="compare.php"><i class="fi-rs-shuffle"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop.html">{{$item->category->name}}</a>
                                    </div>
                                    <h2><a href="product-details.html">{{$item->name}}</a></h2>
                                    <div class="rating-result" title="90%">
                                            <span>
                                                <span>90%</span>
                                            </span>
                                    </div>
                                    <div class="product-price">
                                        <span>{{$item->regular_price}} </span>
                                        <span class="old-price">{{$item->regular_price}}</span>
                                    </div>
                                    <div class="product-action-1 show">
                                        @if($cart->contains($item->id))
                                            <a href="" class="btn btn-danger btn-sm">asdf</a>
                                        @else
                                            <a wire:click.prevent="addCart({{$item->id}}, '{{$item->name}}', {{1}}, {{$item->regular_price}})" aria-label="Add To Cart" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!--End product-grid-4-->
                </div>
            </div>
            <!--End tab-content-->
        </div>
    </section>
</main>
