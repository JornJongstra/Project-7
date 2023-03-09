<!-- Oproepen van de navigatie -->
<?php include('../algemeen/header.php');
?>

<link rel="stylesheet" href="../../css/headerfooter.css">

<!-- het aangeven van welke userlevels er op deze pagina toegestaan zijn -->

</br></br></br></br></br>
<!-- container zorgt er voor dat alles in een bepaalde ruimte blijft op de site -->
<div class="container">
<div class="row">
<?php
// ophalen van php code
try{
    $dbmenu = new PDO ("mysql:host=localhost;dbname=project-7","root","");
    $querymenu = $dbmenu->prepare("SELECT name, discription,id,price FROM menus ");
    $querymenu->execute();
    $resultmenu = $querymenu->fetchAll (PDO::FETCH_ASSOC);
    foreach($resultmenu as &$datamenu){       
        $naammenu = $datamenu['name'];
        $beschrijvingmenu = $datamenu['discription'];
        $idmenu = $datamenu['id'];
        $prijsmenu = $datamenu['price'];
        // database connectie voor de gerechten
        $db = new PDO ("mysql:host=localhost;dbname=project-7","root","");
        $query = $db->prepare("SELECT dish.name, dish.discription FROM dish LEFT JOIN `koppel_dishes_menus` ON `koppel_dishes_menus`.dishid = dish.id LEFT JOIN menus ON `koppel_dishes_menus`.menuid = menus.id WHERE `koppel_dishes_menus`.menuid = $idmenu ");
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
                        </div>
                        <ul class="list-group list-group-flush">

                    <?php
                    foreach($result as &$data){       
                        $naam = $data['name'];
                        $beschrijving = $data['discription'];   
                        //$id = $data['id'];
                        ?>
                            <li class="list-group-item"><?php echo "<b>".$naam."</b><br>".$beschrijving ?></li>
                        <?php
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
<?php include('../algemeen/footer.php'); ?>