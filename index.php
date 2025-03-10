<?php
$index = true;
include_once("header.php");
include_once("main.php");

// Vérification et mise à jour de la requête SQL
$query = "SELECT c.nom, c.telephone, c.ville, cmd.date, art.description, art.prix_unitaire, lc.quantite
          FROM client AS c
          JOIN commande AS cmd ON c.idclient = cmd.idclient
          JOIN ligne_commande AS lc ON cmd.idcommande = lc.idcommande
          JOIN article AS art ON art.idarticle = lc.idarticle";

try {
    $objstmt = $pdo->prepare($query);
    $objstmt->execute();
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    exit; // Arrête le script si une erreur survient
}
?>

<h1 class="mt-5">Accueil</h1>
<table id="datatable" class="display">
    <thead>
        <tr>
            <th></th>
            <th>NOM</th>
            <th>TELEPHONE</th>
            <th>VILLE</th>
            <th>DATE</th>
            <th>DESCRIPTION</th>
            <th>PRIX UNITAIRE</th>
            <th>QUANTITE</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($ligne = $objstmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                        </svg>
                    </a>
                </td>
                <td><?php echo htmlspecialchars($ligne["nom"]); ?></td>
                <td><?php echo htmlspecialchars($ligne["telephone"]); ?></td>
                <td><?php echo htmlspecialchars($ligne["ville"]); ?></td>
                <td><?php echo htmlspecialchars($ligne["date"]); ?></td>
                <td><?php echo htmlspecialchars($ligne["description"]); ?></td>
                <td><?php echo htmlspecialchars($ligne["prix_unitaire"]); ?></td>
                <td><?php echo htmlspecialchars($ligne["quantite"]); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>
</main>
<?php
$objstmt->closeCursor();
include_once("footer.php");
?>
