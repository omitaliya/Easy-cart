@extends('home.layouts.app')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <div class="row">
              
              <div class="col-md-8">
                <div class="sub-title">
                  <h2>Shipping Address</h2>
                </div>
                <div class="card shadow-lg border-0">
                  <div class="card-body checkout-form">
                    <div class="row">
                              <form id="address" class="address">
                                @csrf
                                  @forelse($address as $a)
                                  <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->fname }}" name="fname" id="fname" class="form-control" placeholder="First Name">
                                   <p class="error"></p> </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->lname }}" name="lname" id="lname" class="form-control" placeholder="Last Name">
                                        <p class="error"></p> </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->email }}" name="email" id="email" class="form-control" placeholder="Email">
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="description" id="description" cols="30" rows="3" placeholder="Address" class="form-control">{{ $a->description }}</textarea>
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->city }}" name="city" id="city" class="form-control" placeholder="City">
                                        <p class="error"></p></div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->state }}" name="state" id="state" class="form-control" placeholder="State">
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->pincode }}" name="pincode" id="pincode" class="form-control" placeholder="Zip">
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                  <div class="mb-3">
                                      <input type="text" value="{{ $a->country }}" name="country" id="country" class="form-control" placeholder="Country">
                                      <p class="error"></p></div>            
                              </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $a->mobile }}" name="mobile" id="mobile" class="form-control" placeholder="Mobile No.">
                                        <p class="error"></p> </div>            
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="note" id="note" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control">{{ $a->note }}</textarea>
                                        <p class="error"></p> </div>            
                                </div>
                                @php
                                   $form='filled';
                                @endphp
                                  @empty
                                  <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name">
                                   <p class="error"></p> </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name">
                                        <p class="error"></p> </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="description" id="description" cols="30" rows="3" placeholder="Address" class="form-control"></textarea>
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City">
                                        <p class="error"></p></div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" placeholder="State">
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Zip">
                                        <p class="error"></p> </div>            
                                </div>

                                <div class="col-md-12">
                                  <div class="mb-3">
                                      <input type="text" name="country" id="country" class="form-control" placeholder="Country">
                                      <p class="error"></p></div>            
                              </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No.">
                                        <p class="error"></p> </div>            
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="note" id="note" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                        <p class="error"></p> </div>            
                                </div>

                                @php
                                      $form='empty';
                                @endphp
                                  @endforelse 
                                     
                                  
                                <div class="pt-2">
                                  <button type="submit" class="btn-dark btn btn-block w-100">Save</button>
                              </div>
                            </div>
                        </div>
                      </form>
                    </div>    
                </div>

                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">
                          @foreach (Cart::content() as $c)
                              
                          <div class="d-flex justify-content-between pb-2">
                              <div class="h6">{{ $c->name }}</div>
                              <div class="h6">{{ '₹'.$c->price }}<small>x{{ $c->qty }}</small></div>
                          </div>
                          @endforeach
                            
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Discount</strong></div>
                                <div class="h6"><strong> <p id="discount">₹0</p> </strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>₹0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong><p id="total">₹{{ Cart::subtotal() }}</p></strong></div>
                            </div>  
                        </div>
                    </div>   

                            <div class="input-group apply-coupan mt-4">
                <input type="text" placeholder="Coupon Code" id="coupon_code" class="form-control">
                <button class="btn btn-dark" type="submit" id="applyCoupon">Apply Coupon</button>
            </div>                           
            <p id="error" class="mt-2 ml-2 font-weight-bolder text-danger"></p>
                    
                    
                    <div class="card payment-form ">  
                        <form id="orderForm">      
                            @csrf                
                        <h5 class="card-title h5 text-center">Payment Methods</h4>
                        <div class="form-check">
                          <input type="radio" class="mt-3" checked name="payment" value="cod" id="payment">
                          <label for="payment_1" class="form-check-label">Cash On Delivery</label>
                        </div>
                        
                        
                        {{-- <h3 class="card-title h5 mb-3">Payment Details</h3>
                        <div class="card-body p-0">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div> --}}

                            @if ($form=='filled')
                                
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Order Now</button>
                            </div>
                            @else
                            <div class="pt-4">
                                <h4>Please fill up address to continue!</h4>
                            </div>
                                
                            @endif
                        </div>  
                    </form>                      
                    </div>

                          
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')
    <script>



        $("#applyCoupon").click(function(e)
        {
            e.preventDefault();


            var coupon_code=$("#coupon_code").val();

            $.ajax({
                type: "post",
                url: "{{ route('applyCoupon') }}",
                data:{'code':coupon_code,'_token': '{{ csrf_token() }}'},
                dataType: "json",
                success: function (r) {
                    if(r.status==true)
                    {
                        $("#error").text('');
                        var total = parseFloat(r.total);
                        $('#total').text('₹'+total.toFixed(2));

                        var discountAmount = parseFloat(r.damount);
                        $('#discount').text('-₹' + discountAmount.toFixed(2));


                    }else if(r.status==false)
                    {
                        $("#error").text('');
                        $("#error").text(r.message);
                    }
                }
            });
        })

        $('#orderForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                type: "post",
                url: "{{ route('order') }}",
                data: $(this).serializeArray(),
                dataType: "json",
                success: function (r) {
                    if(r.status=true)
                    {

                        window.location.href="{{ route('home')}}";
                    }
                }
            });
        }); 

      $("#address").submit(function(e)
      {
          e.preventDefault();

          var formdata=$(this).serializeArray();

          $.ajax({
            type: "post",
            url: "{{ route('address') }}",
            data: formdata,
            dataType: "json",
            success: function (r) {
              if(r.status==true)
              {
                location.reload();
              }
              else if(r.status==false)
              {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('invalid-feedback').text('');

                $.each(r.errors, function (key, value) { 
                    $('#'+key).addClass('is-invalid').siblings('p').
                    addClass('invalid-feedback').text(value);
                });
              }
            }
          });
      });
    </script>
@endsection 