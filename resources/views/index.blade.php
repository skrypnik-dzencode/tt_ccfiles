<!doctype html>
<html>
<head>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <h1 style="text-align: center;">Countries cities</h1>
    <upload-file-component :file-types="{{ json_encode($fileTypes) }}"></upload-file-component>
</div>
</body>
</html>
