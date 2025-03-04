<?php

    include_once("header.php");
    include_once("main.php");

    if(!empty($_POST["inputnom"])&&!empty($_POST["inputville"])&&!empty($_POST["inputtel"])){
        $query="INSERT INTO client (nom,ville,telephone) VALUES (:nom,:ville,:telephone)";
        $pdostmt=$pdo->prepare($query);
        $pdostmt->execute(["nom"=>$_POST["inputnom"],"ville"=>$_POST["inputville"],"telephone"=>$_POST["inputtel"]]);
        $pdostmt->closecursor();
        
    
      
       

    }

?>

<h1 class="mt-5">Ajouter un client</h1>

<form class="row g-3" method="POST">
  <div class="col-md-6">
    <label for="inputnom" class="form-label">Nom</label>
    <input type="text" class="form-control" id="inputnom" name="inputnom" required>
  </div>
  <div class="col-md-6">
    <label for="inputville" class="form-label">Ville</label>
    <input type="text" class="form-control" id="inputville" name=inputville required>
  </div>
  <div class="col-12">
    <label for="inputtel" class="form-label">Telephone</label>
    <input type="text" class="form-control" id="inputtel" name="inputtel" required>
  </div>
  <div class="col-12">
    <a href="clients.php"  class="btn btn-danger"> Retour </a>
    <button  type="submit" class="btn btn-primary"> Ajouter</button>
  </div>
</form>

</div>
</main>

<?php
    include_once("footer.php");
?>