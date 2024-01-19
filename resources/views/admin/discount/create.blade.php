@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid my-2">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Create Discount</h1>
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
    <form id="discountForm" name="discountForm">
      <div class="card">
        <div class="card-body">
          <div class="row">

            <div class="col-md-6">
              <div class="mb-3">
                <label for="name">Coupon Code</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="Coupon Code">
                <p></p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Coupon Name">
                <p></p>
              </div>
            </div>

            <div class="col-md-12">
              <div class="mb-3">
                <label for="email">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Discription"></textarea>
                <p></p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="status">Status</label>
                <select name="status" class="form-control" id="status">
                  <option selected disabled>Select Status</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
                <p></p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="status">Type</label>
                <select name="type" class="form-control" id="type">
                  <option selected disabled>Select Type</option>
                  <option value="percent">Percent</option>
                  <option value="fixed">Fixed</option>
                </select>
                <p></p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Max Uses</label>
                <input type="text" name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses Of Coupon">
                <p></p>
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Max Uses User</label>
                <input type="text" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max Uses Of Coupon By One User">
                <p></p>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Min Amount</label>
                <input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="Minimum Amount To Claim Coupon">
                <p></p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Discount</label>
                <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount value in Percent or Rupees">
                <p></p>
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Starts At</label>
                <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" placeholder="Starting Time">
                <p></p>
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email">Expires At</label>
                <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" placeholder="Expiring Time">
                <p></p>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="pb-5 pt-3">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="#" class="btn btn-outline-dark ml-3">Cancel</a>
      </div>
    </form>
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('js')
    <script>
        $("#discountForm").submit(function(e) {
          e.preventDefault();

          $.ajax({
            type: "post",
            url: "{{ route('discount.store') }}",
            data: $(this).serializeArray(),
            dataType: "json",
            success: function (r) {
              if(r.status==false)
              {
                
                $('.is-invalid').removeClass('is-invalid').next('p').removeClass('invalid-feedback').text('');

                $.each(r.errors,function(key,value)
                {


                  $('#'+key).addClass('is-invalid').siblings('p').addClass('invalid-feedback font-weight-bolder').text(value);
                });
              }else
              {
                window.location.href="{{ route('discount.index') }}";
              }
            }
          });
        })
    </script>
@endsection