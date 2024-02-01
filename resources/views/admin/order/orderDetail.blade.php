@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid my-2">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Order: {{ $detail->id }}</h1>
      </div>
      <div class="col-sm-6 text-right">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9">
        <div class="card">
          <div class="card-header pt-3">
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <h1 class="h5 mb-3">Shipping Address</h1>
                <address>
                  <strong>{{ $detail->address->fname.' '.$detail->address->lname }}</strong><br>
                  {{ $detail->address->description.', ' }}{{ $detail->address->city.', ' }}<br>
                  {{ $detail->address->state.', ' }}{{ $detail->address->country.'-' }}{{ $detail->address->pincode }}<br>
                  Phone: {{ $detail->address->mobile }}<br>
                  Email: {{ $detail->address->email }}
                </address>
              </div>



              <div class="col-sm-4 invoice-col">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> {{ $detail->id }}<br>
                <b>Total:</b> ₹{{ $detail->total }}<br>
                <b>Status:</b> <span class="text-success">{{ $status->name }}</span>
                <br>
              </div>
            </div>
          </div>
          <div class="card-body table-responsive p-3">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Product</th>
                  <th width="100">Price</th>
                  <th width="100">Qty</th>
                  <th width="100">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $i)
                    
                <tr>
                  <td>{{ $i->product->title }}</td>
                  <td>₹{{ number_format($i->price,2) }}</td>
                  <td>{{ $i->qty }}</td>
                  <td>₹{{ number_format($i->qty*$i->price,2) }}</td>
                </tr>
                @endforeach
                <tr>
                  <th colspan="3" class="text-right">Subtotal:</th>
                  <td>{{ number_format($detail->total+$detail->damount,2) }}</td>
                </tr>

                <tr>
                  <th colspan="3" class="text-right">Discount:</th>
                  <td>₹{{ number_format($detail->damount,2) ?? 0 }}</td>
                </tr>
                <tr>
                  <th colspan="3" class="text-right">Grand Total:</th>
                  <td>₹{{ number_format($detail->total,2) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <p class="message mt-2 ml-2 font-weight-bolder text-success"></p>
          <div class="card-body">
            <form id="order_status">
              @csrf
            <h2 class="h4 mb-3">Order Status</h2>
            <div class="mb-3">
              <select name="status" id="status" class="form-control">
                <option selected value="Pending">Pending</option>
                <option {{ ($status->name=='Shipped')?'selected':'' }} value="Shipped">Shipped</option>
                <option {{ ($status->name=='Delivered')?'selected':'' }} value="Delivered">Delivered</option>
                <option {{ ($status->name=='Cancelled')?'selected':'' }} value="Cancelled">Cancelled</option>
              </select>
              <input type="hidden" name="order_id" value="{{ $detail->id }}">
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
          </div>
        </div>
        {{-- <div class="card">
          <div class="card-body">
            <h2 class="h4 mb-3">Send Inovice Email</h2>
            <div class="mb-3">
              <select name="status" id="status" class="form-control">
                <option value="">Customer</option>
                <option value="">Admin</option>
              </select>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary">Send</button>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('js')
    <script>
      $("#order_status").submit(function(e)
      {
          e.preventDefault();

        $.ajax({
          url:'{{ route("order_status") }}',
          type:'post',
          data:$(this).serializeArray(),
          success:function(r)
          {
            $(".message").text(r.message);
          }
        });
      });
    </script>
@endsection