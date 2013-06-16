<!doctype html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" >        <!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Gentse Vines</title>
    <link rel="stylesheet" href="{{ URL::to('/assets/css/normalize.css')}}" />
    <link rel="stylesheet" href="{{ URL::to('/assets/css/foundation.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::to('/assets/css/app.css')}}"            />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" />
    <link rel="stylesheet" href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,600'         />

    <script src="{{ URL::to('/assets/js/vendor/custom.modernizr.js')}}" ></script>
    <script src="{{ URL::to('/assets/js/vendor/icanhaz.min.js')}}"      ></script>
    <script>
    	var base_url  = '{{ URL::to('/') }}';
    	var vine_base = '{{ Config::get('vine.base_url') }}';
    	@if (isset($tag))
    	var tag       = '{{ $tag }}';
    	@endif
    	@if (isset($user))
    	var logged_in = true;
    	@else
    	var logged_in = false;
    	@endif
    </script>
</head>
<body>