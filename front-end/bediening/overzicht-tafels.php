<?php 
  include '../algemeen/header.php';
  include '../../includes/bediening/functions-bediening.inc.php';
  include '../../includes/algemeen/dbh.inc.php';
?>
<?php 
//BUG: ERR CACHE


//Haal alle data op uit de tables tabel.
  $tableList = getTables($conn);
  $tableListLength =  mysqli_num_rows($tableList);
  $tableCounter = 1;

//Zorgen dat session->post override, wanneer er geen post is.
  if(!isset($_POST['table'])){
    if(!isset($_SESSION['table'])){
      $_SESSION['table'] = 1;
    }
    $selectedTableId = $_SESSION['table'];
  }elseif(isset($_POST['table'])){
    $_SESSION['table'] = $_POST['table'];
    $selectedTableId = $_SESSION['table'];    
  }
  //Haal de status van die tafel op.
  $selectedTableStatus = getSelectedTable($conn, $selectedTableId);

  //Wanneer de tafel bezet is, dan haal je de reservering id, hoeveelheid gasten en begintijd op.
  if($selectedTableStatus['statusid'] == 1){
    $selectedTableData = getSelectedTableData($conn, $selectedTableId);
  }

?>

<div class="container my-5">
  <div class="row">
    <!-- Hier staan alle tafels in -->
    <div class="col-lg-8 py-3 tables-tab">
      <div class="container">
        <form action="" method="post">
      <?php
          while ($table = $tableList->fetch_assoc()){
            if($tableCounter > 4){
            if($tableCounter % 4 == 1){
              ?><div class="row"><?php
            };
            ?>
              <div class="col-3 center-items"><button id="table-<?= $table["id"]; ?>" name="table" value="<?= $table["id"]; ?>" class="sqr-btn status-<?= $table["statusid"]; ?>"><?= $table["id"]; ?></button></div>
            <?php
            if($tableCounter % 4 == 0){
            ?></div><?php
          };
          }else{
            if($tableCounter == 1){
              ?><div class="row"><?php
            }
            ?>
              <div class="col-3 center-items"><button id="table-<?= $table["id"]; ?>" name="table" value="<?= $table["id"]; ?>" class="sqr-btn status-<?= $table["statusid"]; ?>"><?= $table["id"]; ?></button></div>
            <?php
            if($tableCounter == 4){
              ?></div><?php
            }
          }
          // Check of het een tafel is die niet 
          if($tableCounter % 4 !== 0 && $tableCounter == $tableListLength){
            ?></div><?php
          }
          $tableCounter++;
          }
      ?>
      </form>
      </div>
    </div>
    <div class="col-lg-4 py-3 selected-table-tab">
      <!-- Hier staan alle knoppen menu in -->
      <div class="container">
        <div class="row border-bottom border-white my-2">
          <div class="col-6 selected-tbl-nr"><?= $selectedTableId ?></div>
          <!-- Hier word wat belangrijke tafel data laten zien. -->
          <div class="col-6"><?php
           if($selectedTableStatus['statusid'] == 1){
            ?>
            <p>Reservering Id: <?= $selectedTableData['id']; ?></p>
            <p>Aant pers: <?= $selectedTableData['quantity']; ?></p>
            <p>Starttijd: <?= $selectedTableData['starttijd']; ?></p>
            <p>Naam: <?= $selectedTableData['firstname'] . " " . $selectedTableData['lastname'];  ?></p>
            <?php
           }
           ?></div>
        </div>
        <?php if(isset($selectedTableData['id'])){ ?>
        <div class="row">
          <div class="col-6"><form action="add-to-reservation.php" method="post"><button type="submit" name="reservation_id" value="<?= $selectedTableData['id'] ?>" class="big-sqr-btn btn btn-primary my-1">Bestellen</button></form></div>
          <div class="col-6"><button class="big-sqr-btn btn btn-secondary my-1">Bon uitprinten</button></div>
        </div>
        <?php } ?>
        <div class="row">
          <!-- Check of tafel vrijgemaakt moet worden of dat er juist gasten aan toegevoegd moeten worden. -->
          <?php  if($selectedTableStatus['statusid'] == 1){?>
          <div class="col-6"><form action="../../includes/bediening/clear-table.inc.php" method="post"><button type="submit" name="clear-table" value="<?= $selectedTableId ?>"  class="big-sqr-btn btn btn-danger my-1">Tafel vrij maken</button></form></div>
          <?php }elseif($selectedTableStatus['statusid'] == 2){?>
          <div class="col-6"><form action="add-reservation.php" method="post"><button type="submit" name="add-reservation" value="<?= $selectedTableId ?>" class="big-sqr-btn btn btn-success my-1">Gasten toevoegen</button></form></div>
          <?php }else{} ?>
          <?php if(isset($selectedTableData['id'])){ ?>
          <div class="col-6"><button class="big-sqr-btn btn btn-warning my-1">Bestelde items verwijderen</button></div>
          <?php } ?>
        </div>
        <?php if(isset($selectedTableData['id'])){ ?>
        <div class="row">
          <div class="col-6"><button class="big-sqr-btn btn btn-info my-1">Rekening</button></div>
          <div class="col-6"><button class="big-sqr-btn btn btn-light my-1">Reservering</button></div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<?php include('../algemeen/footer.php'); ?>