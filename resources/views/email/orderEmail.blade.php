<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-header pt-3">
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    <center><h2 class="h5 mb-3">Thanks for shopping with QuickCart!</h2></center>
                    <br>
                    <h4 class="mb-1">Shipping Address</h4>
                    <address>
                      <strong>{{ $mailData['detail']->address->fname.' '.$mailData['detail']->address->lname }}</strong><br>
                      {{ $mailData['detail']->address->description.', ' }}{{ $mailData['detail']->address->city.', ' }}<br>
                      {{ $mailData['detail']->address->state.', ' }}{{ $mailData['detail']->address->country.'-' }}{{ $mailData['detail']->address->pincode }}<br>
                      Phone: {{ $mailData['detail']->address->mobile }}<br>
                      Email: {{ $mailData['detail']->address->email }}
                    </address>
                  </div>
    
    
    
                  <div class="col-sm-4 invoice-col">
                    <br>
                    <b>Order ID:</b> {{ $mailData['detail']->id }}<br>
                    <b>Total:</b> ₹{{ $mailData['detail']->total }}<br>
                    <br>
                  </div>
                </div>
              </div>
              <div class="card-body table-responsive p-3">
                <center><table class="table table-striped" cellspacing=10 cellpadding=4 width=100%>
                  <thead>
                    <tr bgcolor="#CCC" align="center">
                      <th>Product</th>
                      <th width="100">Price</th>
                      <th width="100">Qty</th>
                      <th width="100">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mailData['items'] as $i)
                        
                    <tr>
                      <td align="center">{{ $i->product->title }}</td>
                      <td align="center">₹{{ number_format($i->price,2) }}</td>
                      <td align="center">{{ $i->qty }}</td>
                      <td align="center">₹{{ number_format($i->qty*$i->price,2) }}</td>
                    </tr>
                    @endforeach
                    <hr>
                    <tr>
                      <th colspan="3" class="text-right">Subtotal:</th>
                      <td align="right">{{ number_format($mailData['detail']->total+$mailData['detail']->damount,2) }}</td>
                    </tr>
    
                    <tr>
                      <th colspan="3" class="text-right">Discount:</th>
                      <td align="right">₹{{ number_format($mailData['detail']->damount,2) ?? 0 }}</td>
                    </tr>
                    <tr>
                      <th colspan="3" class="text-right">Grand Total:</th>
                      <td align="right">₹{{ number_format($mailData['detail']->total,2) }}</td>
                    </tr>
    <br><br>
                    
                  </tbody>
                </table></center>
        
                <center><h1>Thank You!</h1></center>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>