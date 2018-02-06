<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>All You Need Is Tuna</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway:300" rel="stylesheet">
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-53153991-12"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA-53153991-12');
</script>
</head>
<body>
<div class="container" id="container">
<div id="app">
<tuna />
</div>
</div>
<script>
window.TUNA_ECHO_HOST = "{{ env('APP_ECHO_URL', '//' . Request::getHost() . ':6001') }}"
</script>
<script src="{{ env('APP_ECHO_URL', '//' . Request::getHost() . ':6001') }}/socket.io/socket.io.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
