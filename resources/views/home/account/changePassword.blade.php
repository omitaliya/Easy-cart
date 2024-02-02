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
                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                        </div>
                        <form id="changePassword">
                            @csrf
                            <div class="card-body p-4">
                                <p id="profile_message" class="font-weight-bolder"></p>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Old Password</label>
                                        <input type="password" name="old_password" id="old_password"
                                            placeholder="Old Password" class="form-control">
                                        <p id="error"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">New Password</label>
                                        <input type="password" name="new_password" id="new_password"
                                            placeholder="New Password" class="form-control">
                                        <p id="error"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            placeholder="Old Password" class="form-control">
                                        <p id="error"></p>
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-dark">Save</button>
                                    </div>
                                </div>
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
    $("#changePassword").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url:"{{ route('storeChangedPassword') }}",
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
                            $("#changePassword")[0].reset();
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