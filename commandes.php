<?php
    $commande=true;
    include_once("header.php");
    include_once("main.php");
    $count=0;
    $list=[];
   
    $query = "SELECT idcommande FROM commande WHERE idcommande IN (SELECT idcommande FROM ligne_commande WHERE commande.idcommande = ligne_commande.idcommande)";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();
    foreach ($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues) {
        foreach ($tabvalues as $tabelements) {
            $list[] = $tabelements;
        }
      } 
?>

    <h1 class="mt-5">Cammandes</h1>
    <a href="addcommande.php"class="btn btn-primary" style="float:right;margin-bottom:20px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
  </svg>
</a>
    <?php
      $query = "SELECT * FROM commande";
      $pdostmt = $pdo->prepare($query);
      $pdostmt->execute();
      //var_dump( $pdostmt->fetchAll(PDO::FETCH_ASSOC));
   ?>
   
    <table id="datatable" class="display">
      <thead>
          <tr>
          <th>ID</th>
            <th>ID client</th>
            <th>DATE</th>
            <th>ACTION</th>
         </tr>
    </thead>
    <tbody>
       <?php while($Ligne= $pdostmt->fetch(PDO::FETCH_ASSOC)):
              $count++;
        
        ?>
       
        <tr>
        <td><?php echo $Ligne["idcommande"]; ?></td>
            <td><?php echo $Ligne["idclient"]; ?></td>
            <td><?php echo $Ligne["date"]; ?></td>
            <td>
               <a href="modifCmd.php?id=<?php echo $Ligne["idcommande"]?>" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                </svg>
              </a>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal"  data-bs-target="#deleteModal<?php echo $count?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                </svg>
              </button>
            </td>
        </tr>
          
        <!-- Modal -->
        <div class="modal fade" id="deleteModal<?php echo $count?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">Suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                voulez vous vraiment supprimer cette commande?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="delete.php?idcmd=<?php echo htmlspecialchars($Ligne["idcommande"]); ?>" class="btn btn-danger">Supprimer</a>
              </div>
             </div>
            </div>
           </div>
            <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour gérer le clic sur "Supprimer" -->
    <script>
        document.getElementById("confirmDelete").addEventListener("click", function () {
            alert("Commande supprimé !");
            
            // Fermer la modale après action
            let deleteModal = bootstrap.Modal.getInstance(document.getElementById("deleteModal"));
            deleteModal.hide();
        });
    </script>
             <?php endwhile; ?>
       </tbody>
    </table>
  </div>
</main>

<?php
    include_once("footer.php");
?>
