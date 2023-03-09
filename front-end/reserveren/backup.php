<?php

include '../../includes/reserveren/function.inc.php';
include '../../includes/algemeen/dbh.inc.php';

$date = date("H:i:s");
$id = 10;
$quantity = 13;

    $max = 50;

    //haalt een reservaring op [id] en pakt de [quantity]
    $sql = "SELECT quantity AS quantity FROM `reservations` WHERE id = $id;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../front-end/reserveren/overview.php");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultById = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $resultByIdFormat = $resultById->fetch_assoc();

    //haalt alle reserveringen op [quantity]
    $resultAll = mysqli_query($conn, "SELECT quantity AS quantity FROM `reservations` WHERE date = '2022-10-14'");
    $rows = $resultAll->fetch_all(MYSQLI_ASSOC);

    // print_r($rows);
    // print_r($resultById->fetch_assoc());
    // die();

    $ceil1 = [];
    foreach ($rows as $row) {
        $ceil1[] = (ceil($row['quantity'] / 4) * 4);
    }

    $sumResultByIdFormat = ceil($resultByIdFormat['quantity'] / 4) *4;

    $minAll = array_sum($ceil1) - $sumResultByIdFormat; 

    $sumQuantity = ceil($quantity / 4)*4;

    $sumAll = $sumQuantity + $minAll;

    $free = $max - $sumAll;

    print_r(array_sum($ceil1));

    print_r($sumQuantity);

    if ($sumQuantity <= $free && $sumAll <= $max) {
        return true;
    } else {
        return false;
    }



    //maakt het een leesbaar array
    // $all = [];
    // foreach ($rows as $row) {
    //     $all[] = $row['quantity'];
    // }

    // $a = $resultById->fetch_assoc();
    // $b = array_sum($all);

    // $minQuantity = $b - $a['quantity'];  

    // print_r($minQuantity);
    // die();

// if(!empty($resultAll)){
//     $ceil = [];
//     foreach ($rows as $row) {
//         $ceil[] = (ceil($row['quantity'] / 4) * 4);
//     }

//     $sumRow = array_sum($ceil);

//     $sumQuantity = ceil($quantity / 4) *4;



//     $sumAll = $sumRow + $sumQuantity;

//     $free = $max - $sumRow;

//     print_r($sumAll);
//     die();

//     if ($quantity <= $free && $sumAll <= $max) {
//         return true;
//     } else {
//         return false;
//     }
//     }
?>