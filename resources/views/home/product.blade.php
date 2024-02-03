@extends('home.layouts.app')

@section('content')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">{{ $product->title }}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">

                            @foreach ($product->images as $key=>$img)
                            <div class="carousel-item {{ ($key==0)?'active':'' }}">

                                <img class="w-100 h-100" src="{{ asset('storage/'.$img->path) }}" alt="Image">
                            </div>
                            @endforeach

                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{ $product->title }}</h1>
                        <div class="d-flex mb-3">
                            <div class="star-rating product mt-2" title="">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    
                                    <div class="front-stars" style="width: {{ $avg_rating_percentage }}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div> 
                            <small class="pt-2 ps-1">({{ $total_rating }} Reviews)</small>
                        </div>
                        <h2 class="price text-secondary"><del>{{ ($product->compare_price!=null) ?
                                '₹'.$product->compare_price :''
                                }}</del></h2>
                        <h2 class="price ">{{ '₹'.$product->price }}</h2>

                        <p>{{ $product->description }}</p>
                        @if ($product->track_qty==1)
                        @if ($product->qty<=0)
                        
                        <button class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;Out Of Stock</button>
                        @else
                        <a class="btn btn-dark" href="javascript:void(0)"
                                onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                        @endif
                    @else
                        
                    <a class="btn btn-dark" href="javascript:void(0)"
                                onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                    @endif
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                    aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                    data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping"
                                    aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                    type="button" role="tab" aria-controls="reviews"
                                    aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <p>
                                    {{ $product->description }}
                                </p>
                            </div>

                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                <p>
                                    <b> Shipping:</b> Enjoy fast and reliable delivery across India. We strive to
                                    dispatch orders promptly, ensuring your product reaches you swiftly and securely.
                                    <br>
                                    <br>
                                    <b>Returns:</b> Not satisfied? Our hassle-free return policy makes it easy. Simply
                                    contact us within 7 days of receiving your order for a seamless return process. Your
                                    satisfaction is our priority.
                                </p>
                            </div>


                            <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                               @if (Auth::check())
                                    @if ($allowed==true)

                                        @if (in_array($product->id,$product_ids))
                                            
                                        <div class="col-md-8">
                                            <div class="row">
                                                <form id="ratingForm">
                                                    @csrf
                                                <h3 class="h4 pb-3">Write a Review</h3>
                                                <div class="form-group mb-3">
                                                    <label for="rating">Rating</label>
                                                    <br>
                                                    <div class="rating" id="rating" style="width: 10rem">
                                                        <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-4" type="radio" name="rating" value="4"/><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                                   </div> <p></p>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">How was your overall experience?</label>
                                                    <textarea name="review"  id="review" class="form-control" cols="30" rows="5" placeholder="How was your overall experience?"></textarea>
                                                    <p></p></div>
                                                <div>
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button class="btn btn-dark">Submit</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                   
                               @endif

                                <div class="col-md-12 mt-3">
                                    <div class="overall-rating mb-3">
                                        <div class="d-flex">
                                            <h1 class="h3 pe-3">{{ number_format($avg_rating,1) }}</h1>
                                            <div class="star-rating mt-2" title="">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    <div class="front-stars" style="width: {{ $avg_rating_percentage }}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="pt-2 ps-2">({{ $total_rating }} Reviews)</div>
                                        </div>
                                        
                                    </div>

                                    @forelse ($rating as $r)

                                    @php
                                        $rating_percentage=($r->rating*100)/5;
                                    @endphp
                                        
                                    <div class="rating-group mb-4">
                                       <span> <strong>{{ $r->user->name }} </strong></span>
                                        <div class="star-rating mt-2" title="">
                                            <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                
                                                <div class="front-stars" style="width: {{ $rating_percentage }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="my-3">
                                            <p>{{ $r->comment }}
    
                                        </p>
                                        </div>
                                    </div>
                                    @empty
                                        {{ "Not rating till now!" }}
                                    @endforelse
    
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                    @forelse ($related as $rp)

                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{ route('product',$rp->id) }}" class="product-img"><img class="card-img-top"
                                    src="{{ asset('storage/'.$rp->images->first()->path) }}" alt=""></a>
                            <a class="whishlist" href="javascript:void(0)" onclick="addToWishlist({{ $rp->id }})"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="{{ route('product',$rp->id) }}">{{ $rp->title }}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>{{ '₹'.$rp->price }}</strong></span>
                                <span class="h6 text-underline"><del>{{ ($rp->compare_price!=null)?
                                        '₹'.$rp->compare_price : ''}}</del></span>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{ 'No Related Products Found' }}
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@section('js')
    <script>
        $("#ratingForm").submit(function (e) { 
            e.preventDefault();
            
            $.ajax({
                type: "post",
                url: "{{ route('saveRating') }}",
                data: $(this).serializeArray(),
                dataType: "json",
                success: function (response) {
                    if(response.status==true)
                    {
                        window.location.href="{{ route('product',$product->id) }}";
                    }else
                    {
                         $('.is-invalid').removeClass('is-invalid');
                         $('.invalid-feedback').removeClass('invalid-feedback').text('');

                        $.each(response.errors, function (key, value) { 
                            $('#'+key).addClass('is-invalid').siblings('p').
                            addClass('invalid-feedback').text(value);
                        });
                    }
                }
            });
        });
    </script>
@endsection
