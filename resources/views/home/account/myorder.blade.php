@extends('home.layouts.app')

@section('content')
<main>
  <section class="section-5 pt-3 pb-3 mb-3 bg-white">
      <div class="container">
          <div class="light-font">
              <ol class="breadcrumb primary-color mb-0">
                  <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                  <li class="breadcrumb-item">Settings</li>
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
                          <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                      </div>
                      <div class="card-body p-4">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead> 
                                      <tr>
                                          <th>Orders Id</th>
                                          <th>Date Purchased</th>
                                          <th>Status</th>
                                          <th>Total</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @forelse ($order as $o)
                                        
                                    <tr>
                                        <td>
                                            <a href="{{ route('order.detail',$o->id) }}">{{ $o->id }}</a>
                                        </td>
                                        <td>{{ onlyDate($o->date) }}</td>
                                        <td>
                                          @if ($o->status=='Pending')
                                              
                                          <span class="badge bg-danger">{{ $o->status }}</span>
                                          @elseif($o->status=='Shipped')
                                              
                                          <span class="badge bg-warning">{{ $o->status }}</span>
                                          @elseif($o->status=='Delivered')
                                              
                                          <span class="badge bg-success">{{ $o->status }}</span>
                                          @endif
                                            
                                        </td>
                                        <td>₹{{ number_format($o->total,2) }}</td>
                                    </tr>                                       
                                    @empty
                                    <tr>
                                        <td>No Orders!</td>
                                    </tr>                                       
                                    
                                    @endforelse
                                  </tbody>
                              </table>
                          </div>                            
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</main>
@endsection