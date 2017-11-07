<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
	@include('layout.partials.head')
</head>

<body>

	@include('layout.partials.nav')

	@yield('content')

	@include('layout.partials.footer')

	@include('layout.partials.footer-scripts')

</body>
</html>
