<!-- Oproepen van de navigatie -->
<?php include('../algemeen/header.php');
include('../algemeen/navigatie.php');
?>
</br></br></br></br></br></br>
<link rel="stylesheet" href="../../css/headerfooter.css">


<div class="container">
<div class="row" style="text-align: center; padding-bottom: 20px; padding-top: 15px; font-size: 20px;">
        <div class="col justify-content-evently fw-bold">    
            Klanten overzicht:
        </div>
    </div>
     <!-- Tabel -->
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Gebruikers niveau</th>
                <th>Email</th>
                <th>Telefoon</th>
                <th>Adres</th>
                <th>Postcode</th>
                <th>Plaats</th>
            </tr>
        </thead>
        <tbody>

        <?php
            $db = new PDO ("mysql:host=localhost;dbname=project-7","root","");
            $query = $db->prepare("SELECT * FROM users");
            $query->execute();
            
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>
                <td>" . $result['firstname'] . "</td>
                <td>" . $result['lastname'] . "</td>
                <td>" . $result['userlevel'] . "</td>
                <td>" . $result['email'] . "</td>
                <td>" . $result['phone'] . "</td>
                <td>" . $result['address'] . "</td>
                <td>" . $result['zipcode'] . "</td>
                <td>" . $result['city'] . "</td>
            </tr>";
            }
        ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Gebruikers niveau</th>
                <th>Email</th>
                <th>Telefoon</th>
                <th>Adres</th>
                <th>Postcode</th>
                <th>Plaats</th>
            </tr>
        </tfoot>
    </table>
</div>

</footer>
<!-- Footer -->
<?php include('../algemeen/footer.php'); ?>
</html>