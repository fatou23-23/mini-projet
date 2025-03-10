<?php
ob_start(); 
$commande = true;
include_once("header.php");
include_once("main.php");

// Récupération des ID clients et articles
$query="SELECT idclient FROM client";
$mon_objstmt=$pdo->prepare($query);
$mon_objstmt->execute();

$query2="SELECT idarticle FROM article";
$objstmt2=$pdo->prepare($query2);
$objstmt2->execute();


if (!empty($_POST)) {
    // Mise à jour de la commande
    $query = "UPDATE commande SET idclient=:idcl, date=:date WHERE idcommande=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "idcl" => $_POST["inputidcl"],
        "date" => $_POST["inputdate"],
        "id" => $_POST["myid"]
    ]);

    // Mise à jour de la ligne de commande
    $query2 = "UPDATE ligne_commande SET idarticle=:idart, idcommande=:idcmd, quantite=:quant WHERE idcommande=:idcmd";
    $pdostmt2 = $pdo->prepare($query2);
    $pdostmt2->execute([
        "idart" => $_POST["inputidarticle"],
        "idcmd" => $_POST["cmd_id"],
        "quant" => $_POST["inputqte"]
    ]);
    $pdostmt2->closeCursor();

    // Redirection après mise à jour
    header("Location: commandes.php");
    exit;
}

if (!empty($_GET["id"])) {
    // Récupération des détails de la commande
    $query = "SELECT * FROM commande 
              JOIN ligne_commande ON ligne_commande.idcommande = commande.idcommande 
              WHERE commande.idcommande = :idcmd";
    $objstmt = $pdo->prepare($query);
    $objstmt->execute(["idcmd" => $_GET["id"]]);
    $row = $objstmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row): ?>
        <h1 class="mt-5">Modifier une commande</h1>
        <form class="row g-3" method="POST">
            <input type="hidden" name="cmd_id" value="<?php echo $_GET["id"] ?>"/>
            <div class="col-md-6">
                <label for="inputidcl" class="form-label">ID client</label>
                <select class="form-control" name="inputidcl" required>
                    <?php
                    foreach ($mon_objstmt->fetchAll(PDO::FETCH_NUM) as $tab) {
                        foreach ($tab as $elmt) {
                            $selected = ($row["idclient"] == $elmt) ? "selected" : "";
                            echo "<option value='{$elmt}' {$selected}>{$elmt}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputdate" class="form-label">Date</label>
                <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row["date"] ?>" required>
            </div>
            <div class="col-md-6">
                <label for="inputidarticle" class="form-label">Article</label>
                <select class="form-control" name="inputidarticle" required>
                    <?php
                    foreach ($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab) {
                        foreach ($tab as $elmt) {
                            $selected = ($row["idarticle"] == $elmt) ? "selected" : "";
                            echo "<option value='{$elmt}' {$selected}>{$elmt}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputqte" class="form-label">Quantité</label>
                <input type="text" class="form-control" id="inputqte" name="inputqte" value="<?php echo $row["quantite"] ?>" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    <?php endif;
    $objstmt->closeCursor();
}

include_once("footer.php");
ob_end_flush(); // Vide et envoie la sortie
?>
