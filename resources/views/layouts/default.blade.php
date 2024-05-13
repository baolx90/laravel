<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>
