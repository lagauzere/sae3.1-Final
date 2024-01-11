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
        html {
            scroll-behavior: smooth;
        }

        body {
            padding-top: 60px;
        }
    </style>
</head>

<body>
    <x-header />
    <div style="width: 100%; margin-bottom: 20px;">
        <div class="field is-grouped is-grouped-centered" style="margin-top: 14px;">
            <div class="box" style="width: 900px; padding-left: 0; padding-right: 0;">
                <section class="hero is-link">
                    <div class="hero-body">
                        <p class="title">
                            Mes plongées
                        </p>
                        <p class="subtitle">
                            Historique
                        </p>
                    </div>
                </section>
                <br>
                <div style="padding-left: 20px; padding-right: 20px;">
                    <?php
                    $divesArray = json_decode(json_encode($dives), true);
                    foreach ($divesArray as $dive) {
                    ?>
                        <div class="box has-background-light">
                            <?php
                                echo "<p>{$dive['DIV_DATE']}<br><strong>Site: </strong>{$dive['sit_name']}  <strong>Encadré par: </strong>{$dive['DVR_FIRST_NAME']} {$dive['dvr_name']}  <strong>Embarcation: </strong>{$dive['shp_name']}<br><strong>Niveau requis: </strong>{$dive['DLV_LABEL']}</p>";
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</body>