@extends('home.layouts.app')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Reset Password</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form id="resetPasswordForm">
                    @csrf
                    <h4 class="modal-title">Reset Password</h4>
                    <p id="invalid"></p>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                    <p></p></div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                    <p></p></div>
                    
                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Reset">              
                </form>			
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
        
            $("#resetPasswordForm").submit(function(e)
            {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url:"{{ route('resetPassword') }}",
                    data:$(this).serializeArray(),
                    success:function(data)
                    {
                        if(data.status==true)
                        {
                            window.location.href="{{ route('home') }}";
                        }
                        else if(data.status==false)
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