<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>@yield('title','HBATS')</title>
        @vite(['resources/css/style.css'])

    </head>
    <body class="@yield('body_class')">
        @yield('content')
</body>
</html>