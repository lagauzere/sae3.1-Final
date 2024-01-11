<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
</head>
<body>
    <x-header/>
    </br>
</br>
</br>
</br>
</br>

    @if($result == true)
        <a href="{{ route('diverlist', ['div_id' => 1]) }}">Lien vers la route avec div_id 1</a>
    @endif

</body>
</html>
