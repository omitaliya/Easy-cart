<footer class="bg-dark mt-5">
	<div class="container pb-5 pt-3">
		<div class="row">
			<div class="col-md-4">
				<div class="footer-card">
					<h3>Get In Touch</h3>
					<p>No dolore ipsum accusam no lorem. <br>
						123 Street, New York, USA <br>
						exampl@example.com <br>
						000 000 0000</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>Important Links</h3>
					<ul>
						<li><a href="about-us.php" title="About">About</a></li>
						<li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>
						<li><a href="#" title="Privacy">Privacy</a></li>
						<li><a href="#" title="Privacy">Terms & Conditions</a></li>
						<li><a href="#" title="Privacy">Refund Policy</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>My Account</h3>
					<ul>
						@if (auth()->check())

						<li><a href="{{ route('myprofile') }}" title="Contact Us">My Profile</a></li>
						<li><a href="{{ route('logout') }}" title="Contact Us">Logout</a></li>
						<li><a href="#" title="Contact Us">My Orders</a></li>
						@else

						<li><a href="{{ route('login') }}" title="Sell">Login</a></li>
						<li><a href="{{ route('register') }}" title="Advertise">Register</a></li>
						@endif
						<li><a href="{{ route('shop') }}" title="Contact Us">Shop</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2023 QuickCart. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="{{ asset('home/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('home/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('home/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('home/js/slick.min.js') }}"></script>
<script src="{{ asset('home/js/custom.js') }}"></script>
<script>
	window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

</script>

<script>
	
function addToCart(id)
    {
        $.ajax({
            type: "post",
            url: "{{ route('addToCart') }}",
            data: {'id': id, '_token': '{{ csrf_token() }}'},
            dataType: "json",
            success: function (r) {
              
                    alert(r.message);
                
            }
        });
    }

		function addToWishlist(id)
    {
        $.ajax({
            type: "post",
            url: "{{ route('addToWishlist') }}",
            data: {'id': id, '_token': '{{ csrf_token() }}'},
            dataType: "json",
            success: function (r) {
							if(r.status==true)
							{

								alert(r.message); 
							}else
							{
								window.location.href="{{ route('login') }}";
							}
            }
        });
    }
</script>
@yield('js')
</body>

</html>