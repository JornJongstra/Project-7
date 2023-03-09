<?php
//Haalt alle tafels op uit de database
function getTables($conn){
    $sql = "SELECT * FROM tables ORDER BY id;";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/overzicht-tafels.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

//Haal alle data die je nodig hebt voor een geselecteerde tafel op.
function getSelectedTable($conn, $selectedTableId){
    $sql = "SELECT * FROM tables WHERE id = ?";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/overzicht-tafels.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $selectedTableId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $resultData->fetch_assoc();
}

//Haal alle reservering data die je nodig hebt voor een geselecteerde tafel op.
function getSelectedTableData($conn, $selectedTableId){
    $sql = "SELECT reservations.id, reservations.quantity, reservations.starttijd, users.firstname, users.lastname FROM tables LEFT JOIN reservations ON tables.reservationid = reservations.id LEFT JOIN users ON reservations.userid = users.id WHERE tables.id = ?";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/overzicht-tafels.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $selectedTableId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $resultData->fetch_assoc();
}

//Haal alle data van reserveringen op
//LETOP moet nog gefilterd worden op speciafieke datum.
function getReservationsAndUsers($conn, $date){
    $sql = "SELECT * FROM reservations LEFT JOIN users ON reservations.userid = users.id WHERE date = ? ORDER BY date;";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-reservation.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);    
}

//Zorgt dat er een reservering aan een tafel toegevoegd word.
function addReservationToTable($conn, $tableId, $reservationId){
    $sql = "UPDATE tables SET reservationid = ? where id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-reservation.php?note=sql-query-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $reservationId, $tableId);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
    mysqli_stmt_close($stmt);
}

//Veranderd de status van een tafel.
function changeTableStatus($conn, $tableId, $statusId){
    $sql = "UPDATE tables SET statusid = ? where id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-reservation.php?note=sql-query-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $statusId, $tableId);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
    mysqli_stmt_close($stmt);   
}

//Leeg de tafel van reservering en verander de status naar vrij.
function clearTable($conn, $tableId){
    $sql = "UPDATE tables SET statusid = 2, reservationid = NULL where id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/overzicht-tafels.php?note=sql-query-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $tableId);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
    mysqli_stmt_close($stmt);  
}

//Haalt alle drankjes op
function getAllMenus($conn){
    $sql = "SELECT * FROM menus;";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-to-reservation.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt); 
}

//Selecteer van suplementen alleen de gene met type 1 (drankjes)
function getAllDrinks($conn){
    $sql = "SELECT * FROM suplements WHERE typeid = 1;";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-to-reservation.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);  
}

//Selecteer van suplementen alleen de gene met type 2 (andere suplementen)
function getAllOtherSuplements($conn){
    $sql = "SELECT * FROM suplements WHERE typeid = 2;";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-to-reservation.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);  
}

function addSuplement($conn, $suplementId, $reservationId){
    $sql = "INSERT INTO koppel_res_sup SET suplementid = ?, reservationid = ?, status_orderid = 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-reservation.php?note=sql-query-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $suplementId, $reservationId);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
    mysqli_stmt_close($stmt);
}

function getAllDishesFromMenu($conn, $menuId){
    $sql = "SELECT * FROM koppel_dishes_menus WHERE menuid = ?;";  
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-to-reservation.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $menuId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
    exit();  
}

function insertMenuDishRes($conn, $dishid, $reservationId, $menuId){
    $sql = "INSERT INTO koppel_res_menu_dish SET menuid = ?, reservationid = ?, dishid = ?, status_orderid = 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/bediening/add-to-reservation.php?note=sql-query-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iii", $menuId, $reservationId, $dishid);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
    mysqli_stmt_close($stmt);
}