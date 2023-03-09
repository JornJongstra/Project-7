<?php
if(!isset($_POST['reservation_id'])){

}else{
    session_start();
    include '../../includes/algemeen/dbh.inc.php';
    include '../../includes/bediening/functions-bediening.inc.php';
    $reservationId = $_POST['reservation_id'];

    if(!isset($_POST['menuId'])){

    }elseif(isset($_POST['menuId'])){
        $menuId = $_POST['menuId'];
        $dishes = getAllDishesFromMenu($conn, $menuId);
        while ($dish = $dishes->fetch_assoc()){
            $result = insertMenuDishRes($conn, $dish['dishid'], $reservationId, $menuId);
            if($result != true){
            header("location: ../../front-end/bediening/add-to-reservation.php?note=sql-query-mislukt");
            }elseif($result == true){
            
            }
        }
        $_POST['menuId'] = NULL;
        $_SESSION['reservationid'] = $reservationId;
        header("location: ../../front-end/bediening/add-to-reservation.php?note=menu-toegevoegd");
        exit();
    }
    

    if(!isset($_POST['drinkId'])){

    }elseif(isset($_POST['drinkId'])){
        $drinkId = $_POST['drinkId'];
        $result = addSuplement($conn, $drinkId, $reservationId);

        if($result != true){
        header("location: ../../front-end/bediening/add-to-reservation.php?note=sql-query-mislukt");
        }elseif($result == true){
        $_POST['drinkId'] = NULL;
        header("location: ../../front-end/bediening/add-to-reservation.php?note=drankje-toegevoegd");
        $_SESSION['reservationid'] = $reservationId;
        exit();
        }

    }

    if(!isset($_POST['otherSuplementId'])){

    }elseif(isset($_POST['otherSuplementId'])){
        $otherSuplementId = $_POST['otherSuplementId'];
        $result = addSuplement($conn, $otherSuplementId, $reservationId);

        if($result != true){
        header("location: ../../front-end/bediening/add-to-reservation.php?note=sql-query-mislukt");
        }elseif($result == true){
        header("location: ../../front-end/bediening/add-to-reservation.php?note=extra-toegevoegd");
        $_SESSION['reservationid'] = $reservationId;
        exit();
        }
    }
}

