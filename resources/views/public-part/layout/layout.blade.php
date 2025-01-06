<html>
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-CPMJW6YF5F"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-CPMJW6YF5F');
        </script>

        <title> @yield('title', 'SOGFBiH') </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api-token" content="@if(Auth()->check()){{ Auth()->user()->api_token }}@else{{ time() }}@endif">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/favicon.ico') }}"/>
        <link href="//fastly-cloud.typenetwork.com/projects/7921/fontface.css?660e9b3f" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Meta tags -->
        @include('public-part.layout.snippets.meta-tags')

        @vite(['resources/css/public-part/layout.scss', 'resources/js/app.js'])
        @yield('js-scripts')
    </head>

    <body>
        <!-- Static element on every page -->
        @include('public-part.layout.snippets.menu')

        <!-- Public content wrapper should be used in every public page -->
        <div class="public-content">
            <!-- Yield data into it -->
            @yield('public-content')
        </div>

        <!-- Static element on every page -->
        @include('public-part.layout.snippets.footer')
    </body>
</html>
