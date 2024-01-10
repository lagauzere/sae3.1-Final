<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
    <style>
        html {scroll-behavior: smooth;}
        body {padding-top: 60px;}
    </style>
</head>
<body>
    <x-header/>
    <p>Mes plongées</p>

    <?php
    print_r($dives);
    ?>
    
    <x-footer/>
</body>