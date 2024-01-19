@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid my-2">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Discount</h1>
      </div>
      <div class="col-sm-6 text-right">
        <a href="{{ route('discount.create') }}" class="btn btn-primary">New Discount</a>
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

        @if(session()->has('success'))
           <p class="text-success">{{ session()->get('success') }}</p>
           @endif
           <p class="delete font-weight-bolder text-danger"></p>

        <div class="card-tools">
          <form action="" method="get">
            <div class="input-group input-group" style="width: 250px;">
              <input type="text" name="keyword" value="{{ Request::get('keyword') }}" name="table_search"
                class="form-control float-right" placeholder="Search by code">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('discount.index') }}" class="btn btn-default">Clear</a>
              </div>
          </form>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th width="60">NO</th>
            <th>Code</th>
            <th>Name</th>
            <th>Discount</th>
            <th>Start At</th>
            <th>Expires At</th>
            <th>Status</th>
            <th width="100">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($discount as $d)
          <tr class="{{ $d->id }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->code }}</td>
            <td>{{ $d->name ?? 'Not Given' }}</td>
            <td>
              @if ($d->type=='percent')
              
              {{ $d->discount_amount }}%
              @else
              
              ₹{{ $d->discount_amount }}
              @endif
            </td>
          
          
              <td>{{ formateDate($d->starts_at) ?? 'Not Given' }}</td>
              <td>{{ formateDate($d->expires_at) ?? 'Not Given' }}</td>
        
              <td>
              @if ($d->status == 1)

              <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
              </svg>
              @else

              <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              @endif

            </td>
            <td>
              <a href="{{ route('discount.edit',$d->id) }}">
                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                  fill="currentColor" aria-hidden="true">
                  <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                  </path>
                </svg>
              </a>
              <a href="javascript:void(0)" onclick="deleteDiscount({{ $d->id }})" class="text-danger w-4 h-4 mr-1">
                <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1"
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path ath fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
                </svg>
              </a>
            </td>
          </tr>
          @empty
          <td>No records found!</td>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer clearfix">
      {{ $discount->links() }}
    </div>
  </div>
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('js')
    <script>
         
function deleteDiscount(id) {
  var url = "{{ route('discount.delete', 'id') }}";
  var newUrl = url.replace('id', id);

  if (confirm('Are you sure you want to delete this?')) {
      $.ajax({
          type: "get",
          url: newUrl,
          success: function (r) {
              if (r.status == true) {
                  $(".delete").text(r.message);
                  $("." + r.id).remove();
              }
          }
      });
  }
}
    </script>


@endsection