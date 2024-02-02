@extends('home.layouts.app')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Forgot Password</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form id="forgotPasswordForm">
                    @csrf
                    <h4 class="modal-title">Forgot Password</h4>
                    <p id="invalid"></p>
                    <div class="form-group">
                        <input type="email" required class="form-control" name="email" id="email" placeholder="Email">
                    <p></p></div>
                
                    <div class="form-group small">
                        <a href="{{ route('login') }}" class="forgot-link">Login ?</a>
                    </div> 
                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Submit">              
                </form>			
                <div class="text-center small">Don't have an account? <a href="{{ route('register') }}">Sign up</a></div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')

    <script>
      $("#forgotPasswordForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
          type: "post",
          url: "{{ route('forgotPassword') }}",
          data: $(this).serializeArray(),
          dataType: "json",
          success: function (r) {
            if(r.status==false)
            {
              $("#invalid").addClass("text-danger").text(r.message);
            }else
            {
              window.location.href="{{ route('forgotPasswordForm') }}";
            }
          }
        });
      })
  </script>
@endsection