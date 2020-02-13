<head>
    <meta charset="utf-8" />
    <title>Juice Apps - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">
    <!-- Jquery Toast css -->
    <link href="{{ asset('assets/libs/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css -->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <script>const url = "{{ config('app.url') }}";
    @auth
    const apiToken = "{{Auth::user()->api_token}}";
    @endauth
    </script>
</head>
