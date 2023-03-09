<?php
    session_start();
if(!isset($_POST['clear-table'])){
    //redirect
}else{
    include '../../includes/bediening/functions-bediening.inc.php';
    include '../../includes/algemeen/dbh.inc.php';
    //Haal de Table Id op
    $tableId = $_POST['clear-table'];
    //zet de waarde van de tafel op default.
    $check = clearTable($conn, $tableId);
    if($check != true){
        $_SESSION['table'] = $tableId;
        header("location: ../../front-end/bediening/overzicht-tafels.php?note=sql-query-mislukt");
    }elseif($check == true){
        header("location: ../../front-end/bediening/overzicht-tafels.php");
    }
}