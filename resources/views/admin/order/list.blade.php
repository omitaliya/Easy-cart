@extends('admin.layouts.app')

@section('content')

<section class="content-header">
  <div class="container-fluid my-2">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Orders</h1>
      </div>
      <div class="col-sm-6 text-right">
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <div class="input-group input-group" style="width: 250px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Orders Id</th>
              <th>Customer</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Total</th>
              <th>Date Purchased</th>
            </tr>
          </thead>
          <tbody>

            @forelse ($order as $o)

            <tr>
              <td><a href="{{ route('adminOrder.detail',$o->id) }}">{{ $o->id }}</a></td>
              <td>{{ $o->user->name }}</td>
              <td>{{ $o->user->email }}</td>
              <td>{{ $o->address->mobile }}</td>
              <td>
                @if ($os->name=='Pending')

                <span class="badge bg-danger">{{ $os->name }}</span>

                @elseif($os->name=='Shipped')

                <span class="badge bg-info">{{ $os->name }}</span>

                @elseif($os->name=='Delivered')

                <span class="badge bg-success">{{ $os->name }}</span>

                @elseif($os->name=='Cancelled')

                <span class="badge bg-success">{{ $os->name }}</span>
                @endif
              </td>
              <td>{{ $o->total }}</td>
              <td>{{ onlydate($o->date) }}</td>
            </tr>
            @empty

            @endforelse

          </tbody>
        </table>
      </div>
      <div class="card-footer clearfix">
        {{ $order->links() }}
      </div>
    </div>
  </div>
  <!-- /.card -->
</section>

@endsection