<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    

    <title>Salle</title>
</head>
<body>
    <?php
        SESSION_START();
        $num="";
        $capacite="";
        $nom="";
        $eror="";
        require "bd.php";
        
        if(!isset($_SESSION['login']))
        {
          header("Location:login.php");
        }
          //code ajouter--------
          if(isset($_POST['Num']) and !isset($_GET['id']) ){

            $num=$_POST['Num'];
            $capacite=$_POST['capacite'];
            $nom=$_POST['Nom'];
            if(empty($capacite) or empty($nom) )
            {
              $eror="nom et capacite sont obligatoire <br>";
            }
            else{
              $query="SELECT * FROM salle where numeroSalle = :num";
              $stat=$con->prepare($query);
              $stat->execute(array(":num"=>$num));
              $data=$stat->fetch();
              if(!$data){

              $query="INSERT INTO salle values (NULL,:num,:nom,:capacite)";
              $stat=$con->prepare($query);
              $stat->execute(
                array(':num' => $num ,':capacite' => $capacite,':nom' => $nom)
              );
            }
            else{
              $eror="numéro de salle deja existe <br>";
            }
        }
      }
          //code modifier--------
          if(isset($_GET['id']))
          {
            $id=$_GET['id'];
            $query="SELECT * FROM salle where id=:id";
            $stat=$con->prepare($query);
            $stat->execute(array(":id"=>$id));
            $data=$stat->fetch();
            $num=$data['numeroSalle'];
            $nom=$data['nomSalle'];
            $capacite=$data['capacite'];
            if(isset($_POST['Num']))
            {
              $num=$_POST['Num'];
              $nom=$_POST['Nom'];
              $capacite=$_POST['capacite'];
             

              $query=" UPDATE salle SET numeroSalle = :num, nomSalle =:nom,capacite = :capacite WHERE id=:id";
              $stat=$con->prepare($query);
              $stat->execute(
                array(":id"=>$id, ":num"=>$num,":nom"=>$nom, ":capacite"=>$capacite)
              );
              header("Location: salle.php");
            }
          }
          
          require "menu.html";


    ?>
<div class="  d-flex justify-content-center mt-5 w-100 ">

<form method="post" class="mb-5  py-5 w-50" id="formContent" action="#">

    
        <label class="d-flex flex-column text-right mr-5  text-info size"> Room number </label>
        <input type="text" name="Num" value="<?= $num ?>" placeholder="Room number"/>
      

        <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">  Room name  </label>
        <input type="text" name="Nom" value="<?= $nom ?>"  placeholder="Room name"/>
      
        <label class="d-flex flex-column text-right mr-5 mt-3 text-info size"> Room capacity </label>

        <input type="number" name="capacite" value="<?= $capacite ?>"  placeholder="Room capacity"/>
      

    <P><?= $eror ?>

    <input type="submit" class="fadeIn fourth mt-5" value="add">

  </form>
</div>
</div>
<div class="container">
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead >
        <tr >
          <td class="text-center">Action</td>
          <td class="text-center"> Room capacity </td>
          <td class="text-center"> Room name </td>
          <td class="text-center">  Room number </td>




        </tr>
        </thead>
        <tbody>
        <?php
          $query="SELECT * FROM salle";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
          foreach($data as $row)
          {
            ?>
            <tr class="text-center">
              <td class="d-flex justify-content-center"><a class="btn btn-danger m-1" href="delete.php?id=<?=$row['id']?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer')"> <img src="image/icons8-delete-67.png"style="width:25px"></a>
            <a class="btn btn-warning m-1" href="salle.php?id=<?=$row['id']?>"><img src="image/icons8-development-64.png" style="width:25px"></a></td>
            <td><?=$row['capacite']?></td>
            <td><?=$row['nomSalle']?></td>
            <td><?=$row['numeroSalle']?></td>

          </tr>
            <?php
          }
        ?>
        </tbody>
        
          </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
 <script>
  $(document).ready(function () {
    $('#example').DataTable();
});
   </script>
</body>
</html>