<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon Temps</title>



    <!-- CSS only -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href=https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css>
    <script src=https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js></script>
    <script type="text/javascript" charset="utf8" src=https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js></script>
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="/project7/css/reservering.css">
    <link rel="stylesheet" href="/project7/css/style.css">
    <link rel="stylesheet" href="/project7/css/bediening.css">
    <link rel="stylesheet" href="/project7/css/login.css">
    <link rel="stylesheet" href="/project7/css/headerfooter.css">
    <script src="/js/app.js"></script>

    <style>
        .logo {
            width: 8%;
        }

        .center {
            position: relative;
            float: left;
        }
    </style>
</head>

<body>
    <!-- header -->
    <header class="d-flex justify-content-center py-3 bg-black">
        <div class="logo">
            <img src="/project7/img/logo.png" class="img-fluid" alt="logo">
        </div>
        <div class="center">
            <ul class="nav nav-pills">
                <li class="nav_home"><a href="/project7/front-end/algemeen/index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="/project7/front-end/menu/menu.php" class="nav-link">Menu</a></li>
                <?php
                $userlevel = !array_key_exists('userlevel', $_SESSION) ? 1 : $_SESSION['userlevel'];
                switch ($userlevel) {
                    case 1: ?>
                        <li class="nav-item"><a href="/project7/front-end/login/login.php" class="nav-link">Login</a></li>
                    <?php
                        break;
                        //gast
                    case 2: ?>
                        <li class="nav-item"><a href="/project7/front-end/reserveren/create.php" class="nav-link">Reserveren</a></li>
                        <li class="nav-item"><a href="/project7/front-end/login/profile/overview.php" class="nav-link">Profiel</a></li>
                    <?php
                        break;
                        //bediening
                    case 4: ?>
                        <li class="nav-item"><a href="/project7/front-end/reserveren/overview.php" class="nav-link">Reserveringen</a></li>
                        <li class="nav-item"><a href="/project7/front-end/bediening/overzicht-tafels.php" class="nav-link">Bediening</a></li>
                        <li class="nav-item"><a href="/project7/front-end/login/profile/overview.php" class="nav-link">Profiel</a></li>
                    <?php
                        break;
                        //admin
                    case 5: ?>
                        <li class="nav-item"><a href="/project7/front-end/reserveren/overview.php" class="nav-link">Reserveringen</a></li>
                        <li class="nav-item"><a href="/project7/front-end/bediening/overzicht-tafels.php" class="nav-link">Bediening</a></li>
                        <li class="nav-item"><a href="/project7/front-end/login/profile/overview.php" class="nav-link">Profiel</a></li>
                <?php
                        break;
                }
                ?>
            </ul>
        </div>
    </header>