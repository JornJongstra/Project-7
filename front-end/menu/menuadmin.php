<!-- Oproepen van de navigatie -->
<?php include('../algemeen/header.php');
?>

<link rel="stylesheet" href="../../css/headerfooter.css">



<!-- container zorgt er voor dat alles in een bepaalde ruimte blijft op de site -->
<div class="container">
<div class="row">
<?php
// ophalen van php code
try{
    $db = new PDO ("mysql:host=localhost;dbname=project-7","root","");
    $querymenu = $db->prepare("SELECT name, discription,id,price FROM menus ");
    $querymenu->execute();
    $resultmenu = $querymenu->fetchAll (PDO::FETCH_ASSOC);
    foreach($resultmenu as &$datamenu){       
        $naammenu = $datamenu['name'];
        $beschrijvingmenu = $datamenu['discription'];
        $idmenu = $datamenu['id'];
        $prijsmenu = $datamenu['price'];
        // database connectie voor de gerechten
        $db = new PDO ("mysql:host=localhost;dbname=project-7","root","");
        $query = $db->prepare("SELECT dish.name, dish.discription, dish.id FROM dish LEFT JOIN `koppel_dishes_menus` ON `koppel_dishes_menus`.dishid = dish.id LEFT JOIN menus ON `koppel_dishes_menus`.menuid = menus.id WHERE `koppel_dishes_menus`.menuid = $idmenu ");
        $query->execute();
        $result = $query->fetchAll (PDO::FETCH_ASSOC);
        ?> 
        <!-- Card voor menu -->
            
                <div class="col-md-3">
                    <br>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $naammenu ?></h5>
                            <p class="card-text"><?php echo $beschrijvingmenu."<br>€ ".$prijsmenu ?></p>
                            <?php echo "<br><a href='?verwijdermenu=$idmenu'>❌</a>"?>
                            <?php
                            if( isset($_GET["verwijdermenu"])){

                                $stop = $_GET["verwijdermenu"];

                                $delete = $db->prepare("DELETE FROM menus WHERE id = :stop");
                                $delete->bindParam('stop',$stop);
                                $delete->execute();
                                header('Location: http://localhost/project7/front-end/menu/menuadmin.php');
                            } ?>
                        </div>
                        <ul class="list-group list-group-flush">

                    <?php
                    foreach($result as &$data){       
                        $naam = $data['name'];
                        $beschrijving = $data['discription'];   
                        $id = $data['id']
                        //$id = $data['id'];
                        ?>
                            <li class="list-group-item">
                                <?php echo "<b>".$naam."</b><br>".$beschrijving ?>
                                <?php echo "<br><a href='?verwijderdish=$id'>Verwijder het gerecht</a>"?>
                                <?php echo "<br><a href='?verwijderhier=$id'>Verwijder het gerecht uit menu</a>"?>
                            </li>
                        <?php
                            if( isset($_GET["verwijderdish"])){

                                $stop = $_GET["verwijderdish"];

                                $delete = $db->prepare("DELETE FROM dish WHERE id = :stop");
                                $delete->bindParam('stop',$stop);
                                $delete->execute();
                                header('Location: http://localhost/project7/front-end/menu/menuadmin.php');
                            }
                            if( isset($_GET["verwijderhier"])){

                                $stop = $_GET["verwijderhier"];

                                $delete = $db->prepare("DELETE FROM `koppel_dishes_menus` WHERE dishid = :stop AND menuid = :menutje");
                                $delete->bindParam('stop',$stop);
                                $delete->bindParam('menutje',$idmenu);
                                $delete->execute();
                                header('Location: http://localhost/project7/front-end/menu/menuadmin.php');
                            }

                    }
                //card en col
                    ?></div>
                </div><?php
    }
    ?>
        </ul>
        <!-- einde row -->
    </div>
    <br>

    <?php
    //error message als er iets fout gaat
} catch (PDOException $e){
    die ("Error!: ".$e->getMessage());
}
?>
<!-- einde container -->
</div>
</br>
<div class="container">
    <!-- Oproepen van de Php code -->
<?php
    require_once "../../includes/menu/menu.inc.php";
?>


<?php include('../algemeen/footer.php'); ?>