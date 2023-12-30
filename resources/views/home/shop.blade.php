@extends('home.layouts.app')

@section('content')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a class="white-text" href="{{ route('shop') }}">Shop</a></li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @foreach (getCategory() as $key=>$cat)
                                <div class="accordion-item">
                                    @if ($cat->sub_category->isNotEmpty())
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key }}"
                                            aria-expanded="false" aria-controls="collapseOne-{{ $key }}">
                                            {{ $cat->name }}
                                        </button>
                                    </h2>
                                    @else
                                    <a href="{{ route('shop',$cat->slug) }}"
                                        class="nav-item nav-link {{ ($selected_category==$cat->id)?'text-primary':'' }} ">{{
                                        $cat->name
                                        }}</a>

                                    @endif
                                    <div id="collapseOne-{{ $key }}"
                                        class="accordion-collapse collapse {{ ($selected_category==$cat->id)?'show':'' }}"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                @forelse ($cat->sub_category as $sb)

                                                <a href="{{ route('shop',[$cat->slug,$sb->slug]) }}" class="nav-item nav-link {{ ($selected_sub_category==$sb->id)?'text-primary':'' }}
                                                    ">{{ $sb->name }}</a>
                                                @empty

                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @foreach (brand() as $br)

                            <div class="form-check mb-2">
                                <input class="form-check-input brand" type="checkbox" value="{{ $br->id }}" onchange="getBrand()" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $br->name }}
                                </label>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    ₹0-₹100
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    ₹100-₹200
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    ₹200-₹500
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    ₹500+
                                </label>
                            </div>
                        </div>
                    </div> --}}
                </div>
                
                <div class="col-md-9">
                    <div class="row pb-3" id="product-container">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option disabled selected>Select Sorting</option>
                                        <option value="latest">Latest</option>
                                        <option value="low">Lowest Price</option>
                                        <option value="high">Highest Price</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @forelse ($product as $pr)

                        <div class="col-md-4 product">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="" class="product-img"><img class="card-img-top"
                                            src="{{ asset('storage/'.$pr->images->first()->path) }}" alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{ $pr->title }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{ '₹'.$pr->price }}</strong></span>
                                        <span class="h6 text-underline text-danger"><del>{{ '₹'.$pr->compare_price ?? ''
                                                }}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                        <h3 class="no-product"></h3>

                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                {{ $product->links() }}
                                
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>

@endsection

@section('js')

<script>

$("#sort").change(function(){

        var url='{{ url()->current() }}?';
        url+='&sort='+$(this).val();
        window.location.href =url;
});


   
 function getBrand(){

var brands=[];

$(".brand").each(function(){
    if($(this).is(':checked')==true)
    {
        brands.push($(this).val());
    }

    
});

$.ajax({
    type:'get',
    url:'{{ route("shop") }}',
    data:{brands: brands},
    success:function(data){
        // Clear existing products
        $('#product-container').html('');

        // Append updated products
        if(data.product.length>0)
        {

            $.each(data.product, function(index, pr){
                    $('#product-container').append(`
                        <div class="col-md-4 product">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="" class="product-img"><img class="card-img-top"
                                        src="{{ asset('storage/') }}/${pr.images[0].path}" alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">${pr.title}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>${'₹' + pr.price}</strong></span>
                                        <span class="h6 text-underline text-danger"><del>${'₹' + (pr.compare_price ?? '')}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `);
                
            });
        }else
        {
            $('#product-container').html('<h3 class="no-product">No products found!</h3>');
        }
    }
});
}





</script>
    
@endsection

