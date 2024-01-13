@extends('home.layouts.app')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Login</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form id="login">
                    @csrf
                    <h4 class="modal-title">Login to Your Account</h4>
                    <p id="invalid"></p>
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                    <p></p></div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <p></p></div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div> 
                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login">              
                </form>			
                <div class="text-center small">Don't have an account? <a href="{{ route('register') }}">Sign up</a></div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
        
            $("#login").submit(function(e)
            {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url:"{{ route('login.user') }}",
                    data:$(this).serializeArray(),
                    success:function(data)
                    {
                        if(data.status=='success')
                        {
                            window.location.href="{{ route('home') }}";
                        }
                        else if(data.status=='invalid')
                        {
                            $("input[type=text],input[type=password]").removeClass('is-invalid');
                            $("#error").removeClass('invalid-feedback').text('');

                            $("#invalid").addClass('text-danger ml-2 text-center').text(data.message);
                        }
                        else if(data.status=='error')
                        {
                            $("input[type=text],input[type=password]").removeClass('is-invalid');
                            $("#error").removeClass('invalid-feedback').text('');
                            $("#invalid").removeClass('has-error').text('');

                            $.each(data.errors, function(i,v)
                            {
                                $("#"+i).addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .text(v);
                            })
                        }
                    }
                });
            })



        });

    </script>
@endsection