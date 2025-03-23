<html>
    <head>
        <title>@yield('page-title', 'Savez općina i gradova FBiH')</title>
        <script src="https://kit.fontawesome.com/e3d0ab8b0c.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/favicon.ico') }}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

        @vite(['resources/css/app.scss', 'resources/css/admin/admin.scss', 'resources/js/app.js'])
    </head>
    <body>
{{--        <div class="loading">--}}
{{--            <img src="{{ asset('files/images/default/loading.gif') }}" alt="">--}}
{{--        </div>--}}
        @include('admin.layout.snippets.menu')
        <!-- Confirm delete -->
        @include('admin.layout.snippets.includes.confirm-delete')

        <!-- Main page content -->
        <div class="main-content">
            <!-- Basic header of every page -->
            @include("admin.layout.snippets.content.content-menu")

            <!-- Main content of every page -->
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"> </script>
        <script>

            $('.summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    // ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', ]], // 'picture', 'video'
                    ['view', ['help']],
                    ['height', ['height']],
                ],
                placeholder: 'Unesite vaš tekst ovdje ..',
                height : 300
            });

            if ( $('.summernote').is('[readonly]') ) {
                $('.summernote').summernote('disable');
            }


        </script>
    </body>
</html>
