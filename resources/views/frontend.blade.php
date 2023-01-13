<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>
		window.user = @json($user)
	</script>
</head>
<body>
	<div id="app"></div>

	@vite('resources/js/app.js')
</body>
</html>
