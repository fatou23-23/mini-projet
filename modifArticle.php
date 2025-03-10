<?php
ob_start(); // Démarre le tampon de sortie
$article = true;
include_once("header.php");
include_once("main.php");

if (!empty($_POST)) {
    $query = "update article set description=:description, prix_unitaire=:pu where idarticle=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "description" => $_POST["inputdesc"], // Correction ici
        "pu" => $_POST["inputpu"],
        "id" => $_POST["myid"]
    ]);
    $pdostmt->closeCursor();
    header("Location: articles.php");
    exit; // Toujours ajouter exit après header()
}

if (!empty($_GET["id"])) {
    $query = "select * from article where idarticle=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute(["id" => $_GET["id"]]);
    while ($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) :
?>

<h1 class="mt-5">Modifier un article</h1>
<form class="row g-3" method="POST">
    <input type="hidden" name="myid" value="<?php echo $row["idarticle"]; ?>"/>
    <div class="col-md-6">
        <label for="inputdesc">Description</label>
        <textarea class="form-control" placeholder="mettre la description" id="inputdesc" name="inputdesc" required><?php echo $row["description"]; ?></textarea>
    </div>
    <div class="col-md-6">
        <label for="inputpu" class="form-label">PU</label>
        <input type="text" class="form-control" id="inputpu" name="inputpu" value="<?php echo $row["prix_unitaire"]; ?>" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
</form>
</div>
</main>
<?php
    endwhile;
    $pdostmt->closeCursor();
}
include_once("footer.php");
ob_end_flush(); // Vide et envoie le tampon
?>
