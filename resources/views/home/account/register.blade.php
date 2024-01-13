@extends('home.layouts.app')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form id="register" name="register">
                    @csrf
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p class="text-danger"></p>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                    <p class="text-danger"></p>
                </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
                    <p class="text-danger"></p>
                </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Password" id="password" name="password">
                    <p class="text-danger"></p>
                </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="cpassword" name="cpassword">
                    <p class="text-danger"></p>
                </div>

                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    <p class="text-danger"></p>
                </div> 

                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form=>			
                <div class="text-center small">Already have an account? <a href="{{ route('login') }}">Login Now</a></div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')
    <script>
        $("#register").submit(function(e) {
            e.preventDefault();


            $("button[type=submit]").prop("disabled", true);

            $.ajax({
                url:"{{ route('registerData') }}",
                type:'post',
                data:$(this).serializeArray(),
                success:function(data) {
                    if(data.status==true)
                    {
                        window.location.href="{{ route('login') }}";
                    }else
                    {

                        $(".text-danger").removeClass('invalid-feedback').addClass('valid-feedback').text('');
                        $("input[type=text]").removeClass('is-invalid').addClass('is-valid');

                        $.each(data.errors,function(key,val){
                            $('#'+key).addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').text(val);
                        })
                    }
                },complete:function(){
                $("button[type=submit]").prop("disabled", false);

                }
            });
        });
    </script>
@endsection