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
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <form id="personal_info">
                            @csrf
                        <div class="card-body p-4">
                            <p id="profile_message" class="text-success font-weight-bolder"></p>
                            <div class="row">
                                <div class="mb-3">               
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ Auth::user()->name }}" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                <p id="error"></p></div>
                                <div class="mb-3">            
                                    <label for="email">Email</label>
                                    <input type="text" value="{{ Auth::user()->email }}" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                    <p id="error"></p></div>
                                <div class="mb-3">                                    
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" id="phone" placeholder="Enter Your Phone" class="form-control">
                                    <p id="error"></p></div>

                                <div class="d-flex">
                                    <button type="submit" class="btn btn-dark">Update</button>
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
        $("#personal_info").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url:"{{ route('update_profile') }}",
                data:$(this).serializeArray(),
                success:function(r)
                {
                    if(r.status==true)
                    {
                        $('.is-invalid').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').text('');
                       
                            $("#profile_message").text(r.message);
                        
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