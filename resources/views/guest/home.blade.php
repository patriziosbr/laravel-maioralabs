<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Maioralabs</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://datatables.net/media/css/site-examples.css">
        
        <link rel="shortcut icon" sizes="76x76" type="image/x-icon" href="https://a0.muscache.com/airbnb/static/logotype_favicon-21cc8e6c6a2cca43f061d2dcabdf6e58.ico">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        {{-- fontawesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- bootstapitalia css--}}
        <link rel="stylesheet" href="{{asset('bootstrap-italia/css/bootstrap-italia.min.css')}}" />
        {{-- datatable --}}
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://datatables.net/media/css/site-examples.css"> --}}
</head>
    </head>
    <body>
      <div id="root"></div>
      <script src="{{asset('js/app.js')}}"></script>
      <script src="{{asset('bootstrap-italia/js/bootstrap-italia.bundle.min.js')}}"></script>
    </body>
</html>
