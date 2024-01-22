@extends('home.layouts.app')

@section('content')
<main>
  <section class="section-5 pt-3 pb-3 mb-3 bg-white">
      <div class="container">
          <div class="light-font">
              <ol class="breadcrumb primary-color mb-0">
                  <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop') }}">Shop</a></li>
                  <li class="breadcrumb-item">Cart</li>
              </ol>
          </div>
      </div>
  </section>

  <section class=" section-9 pt-4">
      <div class="container">
          <div class="row">
            <p id="no_qty" class="font-weight-bolder text-danger"></p>
            @if (Cart::count()>0)
                
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table" id="cart">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($cart as $c)
                              
                          <tr class="{{ $c->rowId }}">
                              <td>
                                  <div class="d-flex align-items-center">
                                      <img src="{{ asset('storage/'.$c->options->pimg->path) }}" width="" height="">
                                      <h2>{{ $c->name }}</h2>
                                  </div>
                              </td>
                              <td>{{ '₹'.$c->price }}</td>
                              <td>
                                  <div class="input-group quantity mx-auto" style="width: 100px;">
                                      <div class="input-group-btn">
                                          <button data-id="{{ $c->rowId }}" class="sub btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                              <i class="fa fa-minus"></i>
                                          </button>
                                      </div>
                                      <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $c->qty }}">
                                      <div class="input-group-btn">
                                          <button data-id="{{ $c->rowId }}" class="add btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                              <i class="fa fa-plus"></i>
                                          </button>
                                      </div>
                                  </div>
                              </td>
                              <td id="{{ $c->rowId }}">
                                  {{ '₹'.$c->qty*$c->price }}
                              </td>
                              <td>
                                  <button onclick="deleteCart('{{ $c->rowId }}')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                              </td>
                          </tr>                               
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">            
                <div class="card cart-summery">
                    <div class="sub-title">
                        <h2 class="bg-white">Cart Summery</h3>
                    </div> 
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <div>Subtotal</div>
                            <div><p id="subtotal">{{ '₹'.Cart::subtotal() }}</p></div>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <div>Shipping</div>
                            <div>₹0</div>
                        </div>
                        <div class="d-flex justify-content-between summery-end">
                            <div>Total</div>
                            <div><p id="total">{{ '₹'.Cart::subtotal() }}</p></div>
                        </div>
                        <div class="pt-5">
                            <a href="{{ route('checkout') }}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>     
            </div>
            @else
            <div class="row">
              <h2 class="text-center">Cart Is Empty!</h2>
            </div>
            @endif
          </div>
      </div>
  </section>
</main>
@endsection

@section('js')
    <script>



      $('.add').click(function(){
      var qtyElement = $(this).parent().prev(); // Qty Input
      var qtyValue = parseInt(qtyElement.val());
      if (qtyValue < 10) {
          qtyElement.val(qtyValue+1);

          var id=$(this).data('id');
          var newQty=parseInt(qtyElement.val());
          updateCart(id,newQty);

      }            
  });

  $('.sub').click(function(){
      var qtyElement = $(this).parent().next(); 
      var qtyValue = parseInt(qtyElement.val());
      if (qtyValue > 1) {
          qtyElement.val(qtyValue-1);

          var id=$(this).data('id');
          var newQty=parseInt(qtyElement.val());
          updateCart(id,newQty);
      }        
  });

 function updateCart(rowId,qty)
  {
    $.ajax({
      type: "post",
      url: "{{ route('updateCart') }}",
      data: {
        'id':rowId,
        'qty':qty,
        '_token': '{{ csrf_token() }}'
      },
      dataType: "json",
      success: function (r) {
        $('#subtotal').text('₹' + r.subtotal);
        $('#total').text('₹' + r.total);
        $('#'+r.id).text('₹' + r.qty_into_price);
       
        if(r.no_qty!=null)
        {
          $('#no_qty').text(r.no_qty);
        }
      }
    });
  }

  function deleteCart(id)
  {
    if(confirm('Are you sure to remove ?'))
    {

      $.ajax({
        type: "post",
        url: "{{ route('deleteCart') }}",
        data: {'id':id, '_token': '{{ csrf_token() }}'},
        dataType: "json",
        success: function (r) {
          $('#no_qty').text(r.message);
          $('.'+r.id).remove();
          $('#subtotal').text('₹' + r.subtotal);
        $('#total').text('₹' + r.total);
        }
      });
    }
  }

    </script>
@endsection