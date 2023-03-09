<?php
//Zorg dat de reservering aan tafel word toegevoegd.
    session_start();
if(!isset($_POST['reservationId']) || !isset($_POST['tableId']) || !isset($_SESSION['table'])){
    header("location: ../../front-end/bediening/add-reservation.php?note=niet-de-juiste-variabele-meegegeven");
}else{
    //Voeg includes toe
    include '../../includes/bediening/functions-bediening.inc.php';
    include '../../includes/algemeen/dbh.inc.php';

    //Haal Post variable op/maak variabelen aan.
    $reservationId = $_POST['reservationId'];
    $tableId = $_POST['tableId'];

    //Update Query op de table tabel.
    $check1 = addReservationToTable($conn, $tableId, $reservationId);

    //Wanneer dit correct is uitgevoerd, update status.
    if($check1 != true){
        $_SESSION['table'] = $tableId;
        header("location: ../../front-end/bediening/add-reservation.php?note=sql-query-mislukt");
    }elseif($check1 == true){
        $statusId = 1;
        $check2 = changeTableStatus($conn, $tableId, $statusId);
        if($check2 != true){
            $_SESSION['table'] = $tableId;
            header("location: ../../front-end/bediening/add-reservation.php?note=sql-query-mislukt");
        }elseif($check2 == true){
            $_SESSION['table'] = $tableId;
            header("location: ../../front-end/bediening/overzicht-tafels.php");
        }
    }
}