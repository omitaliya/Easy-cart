@extends('home.layouts.app')

@section('content')
<main>
  <section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
      <div class="light-font">
        <ol class="breadcrumb primary-color mb-0">
          <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
          <li class="breadcrumb-item">WishList</li>
        </ol>
      </div>
    </div>
  </section>

  <section class=" section-11 ">
    <div class="container  mt-5">
      <div class="row">
        <div class="col-md-3">
          @include('home.account.sidebar')
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h2 class="h5 mb-0 pt-2 pb-2">WishList</h2>
            </div>

            <div class="card-body p-4">
              <p id="message" class="h5 text-danger font-weight-bolder"></p>
              @forelse ($WishList as $w)
              @php
                $image=getImage($w->product->id);
              @endphp
              <div id="{{ $w->product->id }}" class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a
                    class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('product',$w->product->id) }}" style="width: 10rem;">
                    <img src="{{ asset('storage/'.$image->path) }}" alt="Product"></a>
                  <div class="pt-2">
                    <h3 class="product-title fs-base mb-2"><a href="{{ route('product',$w->product->id) }}">{{
                        $w->product->title }}</a></h3>
                    <div class="fs-lg text-accent pt-2">

                      <span class="h6"><strong>₹{{ $w->product->price }}</strong></span>

                      @if ($w->product->compare_price>0)
                      <span class="h6 text-underline text-danger"><del>₹{{ $w->product->compare_price }}</del></span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <a href="javascript:void(0)" onclick="removeProduct({{ $w->product->id }})" class="btn btn-outline-danger btn-sm" type="button"><i
                      class="fas fa-trash-alt me-2"></i>Remove</a>
                </div>
              </div>
              @empty
              {{ "WishList is empty!" }}
              @endforelse
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@section('js')
  <script>
      function removeProduct(id)
      {
        var url='{{ route("removeProduct","id") }}';
        var newUrl=url.replace('id',id);

        if(confirm('Are you sure you want to remove ?'))
        {
          $.ajax({
          type: "get",
          url: newUrl,
          success: function (r) {
            if(r.status==true)
            {
              $("#message").text(r.message);
              $("#"+r.id).remove();
            }else
            {
              window.location.href="{{ route('WishList') }}";
            }
          }
        });
        }

      }
  </script>
@endsection