<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    
    <title>Reservation</title>
    <style>
        #date{
          width: 50% !important;
          background-color: #b8b8b8;
        }
        .sub{
          margin: 0 !important;
          margin-top: 10px !important;
        }
    </style>
</head>
<body onload="onload()">
<?php
        SESSION_START();
        
        if(!isset($_SESSION['login']))
        {
          header("Location:login.php");
        }
        
        require "menu.html";
        require "bd.php";
        $time =date("Y-m-d ");
        
        $temps="اليوم";
        $eror="";
        if(isset($_POST['date']))
        {
          
          $time =$_POST['date'];

          if(empty($_POST['date']))
          {
            $time =date("Y-m-d ");
            $eror="le champ est vide";

          }
          else{
            
          if($time >= date("Y-m-d"))
          {
            
           
            $temps="le ".$time;
          }
          else{
            $eror="la date que vous avez selectionner est deja passé";
          }
        }
        }
        $_SESSION['time']=$time;
        $date_="اليوم";
        
        if(isset($_GET['date_']))
        {
          $date_=$_GET['date_'];
        }
       
    ?>
<div class="container  mt-3 ">
  <div class="d-flex justify-content-between align-items-baseline">
  <div onclick="tous()" >
        <input type="button" style="font-size: 1.2em; font-weight: bold;" value="All reservations" class="sub" >

    </div>
    <input type="date"  name="date_" id="date" onchange="change()"/>

    <?php
      if(!isset($_GET['all']))
      {
    ?>
    <h3 class="sub"> today reservation  :<?= $date_?> </h3>
    <?php
      }
      else
      {
    ?>
     <h3  class="sub">all reservations</h3>
     <?php
      }
    ?>

    

  </div>
<table id="example" class=" table table-striped table-bordered" style="width:100%">

        <thead>
        <tr>
 
          <td class="text-center">action</td>
          <td class="text-center">Morning/Evening/All day</td>
          <td class="text-center">Data show</td>
          <td class="text-center">Hall</td>
          <td class="text-center">Reservation date</td>
          <td class="text-center">Number of people  </td>
          <td class="text-center"> Room number </td>
          <td class="text-center">Type of the Room </td>
          <td class="text-center"> Phone</td>
          <td class="text-center">Association name</td>

        </tr>
        </thead>
        <tbody>
        <?php
        
        if(isset($_GET['date_']))
        {
          
          $query="SELECT * FROM stage.salle s  inner join stage.reservation r on  s.id=r.idSalle inner join stage.association a on a.idAssociation=r.idAssociation 
          WHERE DATE(date_de_rese) = '$date_'";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
        }
        if(isset($_GET['all'])){
          $query="SELECT * FROM stage.salle s  inner join stage.reservation r on  s.id=r.idSalle inner join stage.association a on a.idAssociation=r.idAssociation;";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
        }
        if(!isset($_GET['date_']) and !isset($_GET['all']))
        {
          $abc=date("Y-m-d");
          $query="SELECT * FROM stage.salle s  inner join stage.reservation r on  s.id=r.idSalle inner join stage.association a on a.idAssociation=r.idAssociation 
          WHERE DATE(date_de_rese) = '$abc'";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
        }
       
          foreach($data as $row)
          {
            ?>
          <tr class="text-center">
            <td class="text-center"><a class="btn btn-danger m-1" href="delete_res.php?id=<?= $row["id"]?>" name="botton" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?')"> <img src="image/icons8-delete-67.png"style="width:25px"></a></td>
            <td><?=$row['statut']?></td>
            <?php
            $hall='بدون البهو';
            $proj='بدون جهاز العرض';
            if($row['hall'] == 'oui')
            {
              $hall= 'مع البهو';
            }
            if($row['accesoir'] == 'oui')
            {
              $proj= ' مع جهاز العرض' ;
            }
            ?>
            <td><?=$proj?></td>
            <td><?=$hall?></td>
            <td><?=$row['date_de_rese']?></td>
            <td><?=$row['nombres']?></td>
            <td><?=$row['numeroSalle']?></td>
            <td><?=$row['nomSalle']?></td>
            <td><?=$row['telegsm']?></td>
            <td><?=$row['nom']?></td>
          </tr>
            <?php
          }
        ?>
        </tbody>
        
          </table>
         
</div>
<div class="cadre"></div>
<!-- ----------------------------------------------------------------------------->
<div class="position">
<div class="div">
  <form method="post" action="#"  id="formContent" >
    <div>
    
        <label class="d-flex flex-column text-left ml-4  text-info size">Date</label>  
        <input type="date" class="fadeIn second " name="date">
                        
    </div>
    <P><?= $eror ?>

    <div  >
        <input type="submit"  value="search" onclick="afficher()">

    </div>
  </form>
</div>
</div>
<?php
if(empty($eror))
{
?>
<div class="container" id="show"  >

<h3>Rooms available <?=$temps?></h3>
<table id="example" class="table table-striped table-bordered"  style="width:100% ">
        <thead>
        <tr class="text-center">
          <td>Room number</td>
          <td>Room name</td>
          <td>Capacity</td>
          <td>Availablity</td>
          <td>Reserve</td>
        </tr>
        </thead>
        <tbody>
        <?php
          
          $query="select * from stage.salle
                    where id not in(
                    select idSalle from stage.reservation 
                    where cast(date_de_rese as date) like cast('$time' as date));";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
          foreach($data as $row)
          {
            ?>
            <tr class="text-center">
              <td><?=$row['numeroSalle']?></td>
              <td><?=$row['nomSalle']?></td>
              <td><?=$row['capacite']?></td>
              <td>Jour</td>
              <td  class="text-center"><a class="btn btn-primary text-center" href="choisir_assoc.php?id_salle=<?=$row['id']?>"><img src="image/reservation.jpg"style="width:30px"></a></td>
            </tr>
            <?php
          }
          $query="SELECT * FROM stage.reservation r inner join stage.salle s on s.id=r.idSalle
                  where cast(date_de_rese as date) like cast('$time' as date)
                  and statut not like 'jour'
                  and idSalle not in (
                      SELECT  idSalle FROM stage.reservation
                      where cast(date_de_rese as date) like cast('$time' as date)
                      and statut like 'Soir' and idSalle in(
                        SELECT idSalle FROM stage.reservation
                        where cast(date_de_rese as date) like cast('$time' as date)
                        and statut like 'Matin') );";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
          foreach($data as $row)
          {
            $statut="Matin";
            if($row['statut']=='Matin')
            {
              $statut='Soir';
            }
            ?>
            <tr class="text-center">
              <td><?=$row['numeroSalle']?></td>
              <td><?=$row['nomSalle']?></td>
              <td><?=$row['capacite']?></td>
              <td><?=$statut?></td>
              <td  class="text-center"><a class="btn btn-primary text-center" href="choisir_assoc.php?id_salle=<?=$row['id']?>&statut=<?=$statut?>"><img src="image/reservation.jpg"style="width:30px"></a></a></td>
            </tr>
            <?php
          }
        ?>
        </tbody>
        
          </table>
         
</div>
<?php

}
?>

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
<script type="text/javascript">
 
function afficher()
{
  document.getElementById("show").style.display="block";
}

function tous()
{
  window.location.href ="reservation.php?all=1";
}

function change()
{
  var date = document.getElementById('date').value;
  window.location.href ="reservation.php?date_="+date;
}

function onload()
{  
    var url =window.location.href;
  if(url.slice(-1) =='#')
  {
    afficher();
    var elmntToView =document.getElementById("show");
    elmntToView.scrollIntoView({behavior: "smooth"});
  
  }else {

    document.getElementById("show").style.display="none";

  }
}



</script>