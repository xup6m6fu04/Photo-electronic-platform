<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="text" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="style/Camera-8_240px.png">
    @if(\Illuminate\Support\Facades\Auth::check())
        <title>inredis</title>
    @else
    	<title></title>
    @endif
    <script src="style/js/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/css/plugins.css">
    <link rel="stylesheet" type="text/css" href="style/revolution/css/settings.css">
    <link rel="stylesheet" type="text/css" href="style/revolution/css/layers.css">
    <link rel="stylesheet" type="text/css" href="style/revolution/css/navigation.css">
    <link rel="stylesheet" type="text/css" href="style/revolution/revolution-addons/filmstrip/css/revolution.addon.filmstrip.css">
    <link rel="stylesheet" type="text/css" href="style/revolution/revolution-addons/typewriter/css/typewriter.css">
    <link rel="stylesheet" type="text/css" href="style/type/icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style/css/color/blue.css">
    <link href='https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i' rel='stylesheet' type='text/css'>
</head>
<body>
