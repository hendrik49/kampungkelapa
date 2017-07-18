<!DOCTYPE html>
<html>
	<head>
		<title>Latihan Blade Templates</title>
	</head>
	<body>
		@include('templates.header')

		@yield('content')

		@include('templates.footer')
	</body>
</html>