@extends('admin.layouts.app')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Change Password</h1>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form id="changePasswordForm" name="changePasswordForm">
            @csrf
        <div class="card">
            <div class="card-body">	

              <p id="profile_message" class="font-weight-bolder"></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="old_password">Old Password</label>
                            <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password">
                            <p></p>	
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">	
                            <p></p>
                        </div>
                    </div>	

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">	
                            <p></p>
                        </div>
                    </div>	

                   								
                </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Change</button>
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
    $("#changePasswordForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url:"{{ route('admin.saveChangedPassword') }}",
                data:$(this).serializeArray(),
                success:function(r)
                {
                    if(r.status==true)
                    {
                        $('.is-invalid').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').text('');

                        if(r.RoW=='W')
                        {
                            $("#profile_message").removeClass('text-success');
                            $("#profile_message").addClass('text-danger').text(r.message);
                        }else if(r.RoW=='R')
                        {
                            $("#profile_message").removeClass('text-danger');
                            $("#profile_message").addClass('text-success').text(r.message);
                            $("#changePasswordForm")[0].reset();
                        }
                    }else
                    {
                        $('.is-invalid').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').text('');

                        $.each(r.errors,function(key,value){
                            $('#'+key).addClass('is-invalid').siblings('p').addClass('invalid-feedback').text(value);
                        });
                    }
                }
            });
        });
</script>
@endsection