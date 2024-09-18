
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @if (Auth::check())
        <meta name="user-id" content="{{ Auth::id() }}">
    @endif
    <title>Laravel 10 and Vue 3</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    @vite(['resources/js/Routes/index.js'])
</head>

<body>
    <div id="app">
        <MainLayout></MainLayout>
    </div>  


</body>

</html>