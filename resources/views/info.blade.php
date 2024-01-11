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
    <link rel="stylesheet" href="/resources/css/app.css">
    </link>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased">
    <div style="width: 595px; height: 842px;" id="pdf">
        <h1>FICHE DE SÉCURITÉ</h1>
        <table style="border: 1px solid black; border-collapse: collapse;">
            <?php
            $infoTitles = array("Date", "Directeur de plongée", "Site de plongée", "Effectif", "Sécurité de surface", "Observation > météo et marée");
            $i = 0;
            foreach (json_decode(json_encode($pdfInfo), true)[0] as $info) {
                echo '<tr>';
                echo "<th style=\"border: 1px solid black; border-collapse: collapse;\">$infoTitles[$i]</th>";
                echo "<td style=\"border: 1px solid black; border-collapse: collapse;\">$info</td>";
                echo '</tr>';
                $i += 1;
            }
            ?>
        </table>

        <div id="placeholder">

        </div>
        <script>
            const palanqueesObj = JSON.parse(sessionStorage.getItem("palanquees"));

            for (let i = 1; i < 3; i++) { // for each palanquee
                let title = document.createElement("H1");
                title.innerText = "PALANQUÉE N°" + i + ":";
                let table = document.createElement("table");
                table.style = "border: 1px solid black; border-collapse: collapse;";

                let headerRow = table.createTHead().insertRow(0);
                let headers = ["Nom", "Prenom", "Aptitudes"];
                for (let j = 0; j < headers.length; j++) {
                    let headerCell = headerRow.insertCell(j);
                    headerCell.style = "border: 1px solid black; border-collapse: collapse; font-weight: bold;";
                    headerCell.innerHTML = headers[j];
                }
                let tbody = table.createTBody();
                if (palanqueesObj && palanqueesObj[i]) {
                    let rowData = palanqueesObj[i];

                    for (let j = 0; j < rowData.length; j++) {
                        let row = tbody.insertRow(j);
                        let cell1 = row.insertCell(0);
                        cell1.style = "border: 1px solid black; border-collapse: collapse;";
                        cell1.innerHTML = rowData[j]['DVR_NAME'];
                        let cell2 = row.insertCell(1);
                        cell2.style = "border: 1px solid black; border-collapse: collapse;";
                        cell2.innerHTML = rowData[j]['DVR_FIRST_NAME'];
                        let cell3 = row.insertCell(2);
                        cell3.style = "border: 1px solid black; border-collapse: collapse;";
                        cell3.innerHTML = rowData[j]['DLV_LABEL'];
                    }
                }

                document.getElementById('placeholder').appendChild(title);
                document.getElementById('placeholder').appendChild(table);
            }
        </script>
    </div>
    <button id="download">
        Télécharger le PDF
    </button>
    <script>
        let button = document.getElementById("download");
        let makepdf = document.getElementById("pdf");

        button.addEventListener("click", function() {
            let mywindow = window.open("", "PRINT",
                "height=400,width=600");

            mywindow.document.write(makepdf.innerHTML);

            mywindow.document.close();
            mywindow.focus();

            mywindow.print();
            mywindow.close();

            return true;
        });
    </script>
</body>

</html>