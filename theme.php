<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    

    <title>Thème</title>
</head>
<body>
    <?php
        SESSION_START();
        
        $nom="";
        $eror="";
        require "bd.php";
        
        if(!isset($_SESSION['login']))
        {
          header("Location:login.php");
        }
          //code ajouter--------
          if(isset($_POST['nom']) and !isset($_GET['id']) ){

            
            $nom=$_POST['nom'];
            if(empty($nom) )
            {
              $eror="nom est obligatoire <br>";
            }
            else{
              $query="SELECT * FROM theme where nomThem = :num";
              $stat=$con->prepare($query);
              $stat->execute(array(":num"=>$nom));
              $data=$stat->fetch();
              if(!$data){

              $query="INSERT INTO theme values (NULL,:nom)";
              $stat=$con->prepare($query);
              $stat->execute(
                array(':nom' => $nom)
              );
            }
            else{
              $eror="nom de théme deja existe <br>";
            }
        }
      }
          //code modifier--------
          if(isset($_GET['id']))
          {
            $id=$_GET['id'];
            $query="SELECT * FROM theme where idTheme=:id";
            $stat=$con->prepare($query);
            $stat->execute(array(":id"=>$id));
            $data=$stat->fetch();
            
            $nom=$data['nomThem'];
            
            if(isset($_POST['nom']))
            {
              
              $nom=$_POST['nom'];
             

              $query=" UPDATE theme SET nomThem = :nom WHERE idTheme=:id";
              $stat=$con->prepare($query);
              $stat->execute(
                array(":nom"=>$nom,":id"=>$id)
              );
              header("Location: theme.php");
            }
          }
          

          require "menu.html";

    ?>
<div class="  d-flex justify-content-center mt-5 w-100 ">

<form method="post" class="mb-5  py-5 w-50" id="formContent" action="#">

    
        <label class="d-flex flex-column text-right mr-5  text-info size"> specialtie</label>
        <input type="text" name="nom" value="<?= $nom ?>" placeholder="specialtie"/>

      

    <P><?= $eror ?>

    <input type="submit" class=" mt-5" value="add">

  </form>
</div>
</div>
<div class="container">
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead >
        <tr >
          <td class="text-center">Action</td>
          <td class="text-center">  specialtie </td>
          




        </tr>
        </thead>
        <tbody>
        <?php
          $query="SELECT * FROM theme";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
          foreach($data as $row)
          {
            ?>
            <tr class="text-center">
              <td class="d-flex justify-content-center"><a class="btn btn-danger m-1" href="deleteth.php?id=<?=$row['idTheme']?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ! \nTous les associations de ce théme vont étre suprimer')"> <img src="image/icons8-delete-67.png"style="width:25px"></a>
            <a class="btn btn-warning m-1" href="theme.php?id=<?=$row['idTheme']?>"><img src="image/icons8-development-64.png" style="width:25px"></a></td>
            <td><?=$row['nomThem']?></td>
            

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