@extends('home.layouts.app')

@section('content')
<main>
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('home/images/carousel-1-m.jpg') }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('home/images/carousel-1.jpg') }}" />
                        <img src="images/carousel-1.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('shop','kids-wear') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('home/images/carousel-2-m.jpg') }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('home/images/carousel-2.jpg') }}" />
                        <img src="images/carousel-2.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Mens Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('shop','mens-fashion') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('home/images/carousel-3-m.jpg') }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('home/images/carousel-3.jpg') }}" />
                        <img src="images/carousel-2.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('shop','womens-fashion') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-3">
        <div class="container">
            <div class="section-title">
                <h2>Categories</h2>
            </div>
            <div class="row pb-3">
                @forelse ($categories as $cat)
                    
                <div class="col-lg-3">
                    <a href="{{ route('shop',$cat->slug) }}" style="color: #000000">  
                        <div class="cat-card">
                        <div class="left">
                            <img src="{{ asset('home/images/category.jpg') }}" alt="" class="img-fluid">
                        </div>
                        <div class="right">
                            <div class="cat-data">
                                <h2>{{ $cat->name }}</h2>
                
                                <p class="text-muted">{{ $cat->product_count }} Products</p>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                @empty
                    {{ "No Category Found!" }}
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>
            <div class="row pb-3">

                @foreach ($featured_product as $fp)

                <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{ route('product',$fp->id) }}" class="product-img"><img class="card-img-top"
                                    src="{{ asset('storage/'.$fp->images->first()->path) }}" alt=""></a>
                            <a class="whishlist" href="javascript:void(0)" onclick="addToWishlist({{ $fp->id }})"><i class="far fa-heart"></i></a>

                            @if ($fp->track_qty==1)
                            @if ($fp->qty<=0)
                            
                            <div class="product-action">
                                <button class="btn btn-dark"> Out Of Stock
                                </button>                            
                            </div>
                            @else
                            <div class="product-action">
                                <a class="btn btn-dark" href="javascript:void(0)"
                                onclick="addToCart({{ $fp->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>                            
                            </div>
                            @endif
                        @else
                            
                        <div class="product-action">
                            <a class="btn btn-dark" href="javascript:void(0)"
                            onclick="addToCart({{ $fp->id }})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>                            
                        </div>
                        @endif
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="{{ route('product',$fp->id) }}">{{ $fp->name }}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>{{ '₹'.$fp->price }}</strong></span>
                                <span class="h6 text-underline text-danger"><del>{{ ($fp->compare_price!=null) ?
                                        '₹'.$fp->compare_price :''
                                        }}</del></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Produsts</h2>
            </div>
            <div class="row pb-3">

                @foreach ($latest_product as $lp)

                <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{ route('product',$lp->id) }}" class="product-img"><img class="card-img-top"
                                    src="{{ asset('storage/'.$lp->images->first()->path) }}" alt=""></a>
                            <a class="whishlist" href="javascript:void(0)" onclick="addToWishlist({{ $lp->id }})"><i class="far fa-heart"></i></a>
                            
                            @if ($lp->track_qty==1)
                            @if ($lp->qty<=0) <div class="product-action">
                                <button class="btn btn-dark"> Out Of Stock
                                </button>
                        </div>
                        @else
                        <div class="product-action">
                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $lp->id }})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>
                        </div>
                        @endif
                        @else

                        <div class="product-action">
                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $lp->id }})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>
                        </div>
                        @endif


                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="{{ route('product',$lp->id) }}">{{ $lp->name }}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>{{ '₹'.$lp->price }}</strong></span>
                            <span class="h6 text-underline text-danger"><del>{{ ($lp->compare_price!=null) ?
                                    '₹'.$lp->compare_price :''
                                    }}</del></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </section>
</main>
@endsection