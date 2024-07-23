<!DOCTYPE html>
<html class="no-js" lang="en_AU" >

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>EasyCart</title>
	<meta name="description" content="" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />

	<meta property="og:locale" content="en_AU" />
	<meta property="og:type" content="website" />
	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:title" content="" />
	<meta property="og:description" content="" />
	<meta property="og:url" content="" />
	<meta property="og:image" content="" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="" />
	<meta property="og:image:height" content="" />
	<meta property="og:image:alt" content="" />

	<meta name="twitter:title" content="" />
	<meta name="twitter:site" content="" />
	<meta name="twitter:description" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:image:alt" content="" />
	<meta name="twitter:card" content="summary_large_image" />

	<link rel="stylesheet" type="text/css" href="{{ asset('home/css/slick.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('home/css/slick-theme.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('home/css/video-js.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('home/css/style.css')}}" />

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
		rel="stylesheet">

	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>

<body data-instant-intensity="mousedown">

	<div class="bg-light top-header">
		<div class="container">
			<div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
				<div class="col-lg-4 logo">
					<a href="{{ route('home') }}" class="text-decoration-none">
						<span class="h1 text-uppercase text-bg danger bg-dark px-2">Easy</span>
						<span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Cart</span>
					</a>
				</div>
				<div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
					
					@if (auth()->check())
							@if (auth()->user()->role==1)
								<a href="{{ route('admin.home') }}" class="nav-link text-dark">Admin Panel</a>
							@endif
							<a href="{{ route('myprofile') }}" class="nav-link text-dark">My Account</a>
					@else
							
							<a href="{{ route('login') }}" class="nav-link text-dark">Login</a>
					@endif
					
					<form action="{{ route('shop') }}" method="get">
						<div class="input-group">
							<input type="search" value="{{ Request::get('search') }}" placeholder="Search For Products" name="search" id="search" class="form-control">
							<button type="submit" class="input-group-text">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<header class="bg-dark">
		<div class="container">
			<nav class="navbar navbar-expand-xl" id="navbar">
				<a href="index.php" class="text-decoration-none mobile-logo">
					<span class="h2 text-uppercase text-primary bg-dark">Online</span>
					<span class="h2 text-uppercase text-white px-2">SHOP</span>
				</a>
				<button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
					<!-- <span class="navbar-toggler-icon icon-menu"></span> -->
					<i class="navbar-toggler-icon fas fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<!-- <li class="nav-item">
          				<a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        			</li> -->


						@if (!empty(getCategory()))
						@foreach (getCategory() as $cat)

						<li class="nav-item dropdown">
							@if ($cat->sub_category->isNotEmpty())
								<button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
									aria-expanded="false">
									{{ $cat->name }}
								</button>
							@else
								<a class="btn btn-dark " href="{{ route('shop',$cat->slug) }}">{{ $cat->name }}</a>
							@endif


							<ul class="dropdown-menu dropdown-menu-dark">
								@foreach ($cat->sub_category as $sub_cat)
								<li><a class="dropdown-item nav-link" href="{{ route('shop',[$cat->slug,$sub_cat->slug]) }}">{{ $sub_cat->name }}</a></li>
								@endforeach
							</ul>
							</li>
							@endforeach
							@endif

					</ul>
				</div>
				<div class="right-nav py-0">
					<a href="{{ route('cart') }}" class="ml-3 d-flex pt-2">
						<i class="fas fa-shopping-cart text-primary"><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
							{{ Cart::content()->count() }}
						</span></i>
						
					</a>
				</div>
			</nav>
		</div>
	</header>