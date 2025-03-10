<?php
ob_start(); // Démarre la mise en tampon

$commande=true;
include_once("header.php");
include_once("main.php");
$query="select idclient from client";
$objstmt=$pdo->prepare($query);
$objstmt->execute();

$query2="select idarticle from article";
$objstmt2=$pdo->prepare($query2);
$objstmt2->execute();


if (!empty($_POST["inputidcl"]) && !empty($_POST["inputdate"])) {
    $query = "insert into commande (idclient,date) values (:idcl,:date)";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute(["idcl" => $_POST["inputidcl"],"date" => $_POST["inputdate"]]);
    $idcmd=$pdo->lastInsertId();
    $query2 = "insert into ligne_commande (idarticle,idcommande,quantite) values (:idart,:idcmd,:quant)";
    $pdostmt2 = $pdo->prepare($query2);
    $pdostmt2->execute(["idart" => $_POST["inputidarticle"],"idcmd" => $idcmd,"quant" => $_POST["quantite"]]);
    $pdostmt2->closeCursor();
    header("Location:commandes.php"); 
    exit(); 
}

ob_end_flush(); // Envoie le contenu tamponné
?>


<h1 class="mt-5">Ajouter une commande</h1>

<form class="row g-3" method="POST">
  <div class="col-md-6">
    <label for="inputidcl" class="form-label">ID client</label>
    <select class="form-control" name="inputidcl" required>
        <?php
        foreach($objstmt->fetchAll(PDO::FETCH_NUM)as $tab){
            foreach($tab as $elmt){
                echo "<option value=".$elmt.">".$elmt."</option>";
            }
        }
        ?>
    </select>
  </div>
  <div class="col-md-6">
    <label for="inputdate" class="form-label">Date</label>
    <input type="date" class="form-control" id="inputdate" name=inputdate required>
  </div>
  <div class="col-md-6">
    <label for="inputidarticle" class="form-label">Article</label>
    <select class="form-control" name="inputidarticle" required>
        <?php
        foreach($objstmt2->fetchAll(PDO::FETCH_NUM)as $tab){
            foreach($tab as $elmt){
                echo "<option value=".$elmt.">".$elmt."</option>";
            }
        }
        ?>
    </select>
  </div>
  <div class="col-md-6">
    <label for="inputqte" class="form-label">Quantité</label>
    <input type="text" class="form-control" id="inputqte" name=inputqte required>
  </div>
  <div class="col-12">
    <button  type="submit" class="btn btn-primary"> Ajouter</button>
  </div>
</form>

</div>
</main>

<?php
    include_once("footer.php");
?>