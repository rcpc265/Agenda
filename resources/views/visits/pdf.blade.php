<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .center{
            text-align: center;

        }
        .logo{
            height: 70px;
            width: 180px;
        }
        .contenedor{
            margin-left: 78%;
            margin-top: -7%;
        }

        .cabecera{
            background-color: black;
            color: white;
            text-align: center;

        }

        .table{
            text-align: center;
            font-size: 16px;

        }

    </style>

</head>
<body>

    <img class="logo" src="img/brand/logo_visitasMPP.png" alt="logo visitas">



    <p class="contenedor">
        <?php date_default_timezone_set('America/Lima');
            echo "Fecha: ". date("Y-m-d") ." Hora: " .date('h:i:s a');
        ?>
    </p>
    <hr>
    <h1 class="center">Registro de Visitas </h1>
    <h3 class="center">5 – 9 jun 2023</h3>

    <h2 >Personas Naturales</h2>
    <table class="table">
        <thead class="cabecera">
            <tr>
                <th scope="col" width="20%">Asunto</th>
                <th scope="col" width="15%">Estado</th>
                <th scope="col" width="25%">Nombre del visitante</th>
                <th scope="col" width="15%">Fecha</th>
                <th class="text-center" scope="col" width="25%">Hora de inicio y<br>Hora final</th>
            </tr>
        </thead>
    </table>

    <h2 >Personas Juridicas</h2>
    <table class="table">
        <thead class="cabecera">
            <tr>
                <th scope="col" width="20%">Asunto</th>
                <th scope="col" width="15%">Estado</th>
                <th scope="col" width="25%">Nombre del visitante</th>
                <th scope="col" width="15%">RUC</th>
                <th scope="col" width="15%">Fecha</th>
                <th class="text-center" scope="col" width="25%">Hora de inicio y<br>Hora final</th>

            </tr>
        </thead>
    </table>






</body>
</html>
