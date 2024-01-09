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
</head>

<body class="antialiased">
    <x-header/>
    <div style = "position: relative; height: 600px;">
        <div style="filter: brightness(50%);width:100%;">
            <img style="-webkit-filter: grayscale(100%); filter: grayscale(100%); position: absolute; width: 100%; height: 600px; object-fit: cover;" src="https://scontent-cdg4-1.xx.fbcdn.net/v/t39.30808-6/274114453_4869398949842551_7947007209376136064_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=3635dc&_nc_ohc=-ORft8H3UzYAX8rXaMd&_nc_ht=scontent-cdg4-1.xx&oh=00_AfDQ1LVArhdv-RI5V_NZjPMGORtDSvcKI81cjnXZ-0u_Wg&oe=65A25CAA" alt="sea">
        </div>
        <h1 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size:xx-large;">Bonjour</h1>
    </div>
    <div class="field is-grouped is-grouped-centered" style="margin-top: 14px;">
        <form class="box" style="width: 400px;" method="POST" id="connexion">
            @csrf
            <div class="field">
                <label class="label">N° de licence</label>
                <div class="control">
                    <input class="input" type="licence" name="licence" placeholder="A-XX-XXXXXX">
                </div>
            </div>

            <div class="field">
                <label class="label">Mot de passe</label>
                <div class="control">
                    <input class="input" type="password" name="password" placeholder="********">
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <button class="button is-info" type="submit">Plonger</button>
            </div>
        </form>
    </div>
    <x-footer/>
</body>

</html>
