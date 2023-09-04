@props([
	'title',
	'h1' => null
])

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.scss'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @if (session('alert'))
        <div class="alert alert-info" role="alert">
            {{ session('alert') }}
        </div>
    @endif
    {{ $slot }}

@vite(['resources/js/app.js'])
</body>
</html>

