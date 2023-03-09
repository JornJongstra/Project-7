<!-- Oproepen van de navigatie -->
<?php include('../algemeen/header.php');
?>
<link rel="stylesheet" href="../../css/headerfooter.css">

    <!-- Oproepen van de Php code -->
<?php
    require_once "../../includes/menu/menu.inc.php";
?>
<div>
<h5>Gerecht toevoegen</h5>
</div>
    <div class="w-50 p-3">
    <div>
        <!-- Formulier voor gerecht -->
        <form method="POST" formaction="../../includes/menu/menu.inc.php">
            <input class="input-group mb-3 input-tv-form" type="text" name="naam" placeholder="Naam"/>
            <input class="input-group mb-3 input-tv-form" type="text" name="beschrijving" placeholder="beschrijving"/>
            <select class="input-group mb-3 input-tv-form" name='menu'>
            <?php
                foreach($resultmenu as &$datamenu){       
                    $select = $datamenu['name'];
                    $id = $datamenu['id'];
                    ?><option value="<?php  echo $id; ?>"><?php echo $select; ?></option><?php
                }
                ?>
            </select>
            <input class="input-group mb-3 submit-tv-form" type="submit" name="gerechtaan" value="Voeg toe"/>
        </form>
    </div>
    <h5>Menu toevoegen</h5>
    <div>
        <!-- Formulier voor menu -->
        <form method="POST" formaction="../../includes/menu/menu.inc.php">
            <input class="input-group mb-3 input-tv-form" type="text" name="naam" placeholder="Naam"/>
            <input class="input-group mb-3 input-tv-form" type="text" name="beschrijving" placeholder="beschrijving"/>
            <input class="input-group mb-3 input-tv-form" type="number" name="prijs" placeholder="prijs"/>
            <input class="input-group mb-3 submit-tv-form" type="submit" name="menuaan" value="Voeg toe"/>
        </form>
    </div>
    <h5>Gerecht aan een menu toevoegen</h5>
    <div>
        <!-- Formulier voor menu -->
        <form method="POST" formaction="../../includes/menu/menu.inc.php">
            <select class="input-group mb-3 input-tv-form" name='menu'>
            <?php
                foreach($resultmenu as &$datamenu){       
                    $select = $datamenu['name'];
                    $id = $datamenu['id'];
                    ?><option value="<?php  echo $id; ?>"><?php echo $select; ?></option><?php
                }
                ?>
            </select>
            <select class="input-group mb-3 input-tv-form" name='gerecht'>
            <?php
                foreach($result as &$data){       
                    $select = $data['name'];
                    $id = $data['id'];
                    ?><option value="<?php  echo $id; ?>"><?php echo $select; ?></option><?php
                }
                ?>
            </select>
            <input class="input-group mb-3 submit-tv-form" type="submit" name="table" value="Voeg toe" onClick="window.location.reload()"/>
        </form>
    </div>
    <h5>Gerecht aanpassen</h5>
    <div>
        <!-- Formulier voor verander -->
        <form method="POST" formaction="../../includes/menu/menu.inc.php">
            <select class="input-group mb-3 input-tv-form" name='id'>
                <?php
                    foreach($result as &$data){       
                        $select = $data['name'];
                        $id = $data['id'];
                        ?><option value="<?php  echo $id; ?>"><?php echo $select; ?></option><?php
                    }
                ?>
            </select>
            <input class="input-group mb-3 input-tv-form" type="text" name="naam" placeholder="Naam"/>
            <input class="input-group mb-3 input-tv-form" type="text" name="beschrijving" placeholder="beschrijving"/>
            <input class="input-group mb-3 submit-tv-form" type="submit" name="verander" value="Verander"/>
        </form>
    </div>
    <h5>Menu aanpassen</h5>
    <div>
        <!-- Formulier voor verander -->
        <form method="POST" formaction="../../includes/menu/menu.inc.php">
            <select class="input-group mb-3 input-tv-form" name='id'>
                <?php
                    foreach($resultmenu as &$datamenu){       
                        $select = $datamenu['name'];
                        $id = $datamenu['id'];
                        ?><option value="<?php  echo $id; ?>"><?php echo $select; ?></option><?php
                    }
                ?>
            </select>
            <input class="input-group mb-3 input-tv-form" type="text" name="naam" placeholder="Naam"/>
            <input class="input-group mb-3 input-tv-form" type="text" name="beschrijving" placeholder="beschrijving"/>
            <input class="input-group mb-3 input-tv-form" type="text" name="prijs" placeholder="prijs"/>
            <input class="input-group mb-3 submit-tv-form" type="submit" name="verandermenu" value="Verander"/>
        </form>
    </div>
    <!-- einde container -->
</div>

<?php include('../algemeen/footer.php'); ?>
<!-- in menu direct de informatie kunnen aanpassen en verwijderen -->