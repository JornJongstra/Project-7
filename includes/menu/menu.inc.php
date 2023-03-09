<?php
$header = false;

try{
    $db = new PDO ("mysql:host=localhost;dbname=project-7","root","");
    $query = $db->prepare("SELECT * FROM dish");
    $query->execute();
    $result = $query->fetchAll (PDO::FETCH_ASSOC);

    $querymenu = $db->prepare("SELECT * FROM menus");
    $querymenu->execute();
    $resultmenu = $querymenu->fetchAll (PDO::FETCH_ASSOC);

    $querytable = $db->prepare("SELECT * FROM `koppel_dishes_menus`");
    $querytable->execute();
    $resulttable = $querytable->fetchAll (PDO::FETCH_ASSOC);
    
    if(isset($_POST['gerechtaan'])){
        $naam = $_POST['naam'];
        $beschrijving = $_POST['beschrijving'];   
        $query = $db->prepare("INSERT INTO dish(name, discription) VALUES(:naam, :beschrijving)");
        $query->execute(["naam" =>$naam,"beschrijving"=>$beschrijving]);

        $queryid = $db->prepare("SELECT * FROM dish WHERE name= '$naam'"); 
        $queryid->execute();
        $resultid = $queryid->fetch (PDO::FETCH_ASSOC);
        
        $menu = $_POST['menu'];
        $querytable = $db->prepare("INSERT INTO `koppel_dishes_menus`(menuid, dishid) VALUES(:menu, :gerecht)");
        $querytable->execute(["menu" =>$menu,"gerecht"=>$resultid['id']]);
        $header = true;
    }

    if(isset($_POST['table'])){
        $menu = $_POST['menu'];
        $gerecht = $_POST['gerecht'];   
        $querytable = $db->prepare("INSERT INTO `koppel_dishes_menus`(menuid, dishid) VALUES(:menu, :gerecht)");
        $querytable->execute(["menu" =>$menu,"gerecht"=>$gerecht]);
        $header = true;
    }

    if(isset($_POST['menuaan'])){
        $naam = $_POST['naam'];
        $beschrijving = $_POST['beschrijving'];   
        $prijs = $_POST['prijs'];  
        $querymenu = $db->prepare("INSERT INTO menus(name, discription,price) VALUES(:naam, :beschrijving, :prijs)");
        $querymenu->execute(["naam" =>$naam,"beschrijving"=>$beschrijving,"prijs"=>$prijs]);
        $header = true;
    }

    if(isset($_POST['verander'])){
        $naam = $_POST['naam'];
        $beschrijving = $_POST['beschrijving'];   
        $id = $_POST['id'];
        $query = $db->prepare("UPDATE dish SET name=:naam, discription=:beschrijving WHERE id=:id");
        $query->execute(["naam" =>$naam,"beschrijving"=>$beschrijving,"id"=>$id]);
        $header = true;
    }

    if(isset($_POST['verandermenu'])){
        $naam = $_POST['naam'];
        $beschrijving = $_POST['beschrijving'];  
        $prijs = $_POST['prijs'];    
        $id = $_POST['id'];
        $query = $db->prepare("UPDATE menus SET name=:naam, discription=:beschrijving, price=:prijs WHERE id=:id");
        $query->execute(["naam" =>$naam,"beschrijving"=>$beschrijving,"id"=>$id,"prijs"=>$prijs]);
        $header = true;
    }

} catch (PDOException $e){
    die ("Error!: ".$e->getMessage());
}
if($header){
    $header=false;
    header('Location: http://localhost/project7/front-end/menu/menutoevoegen.php');
}
?>