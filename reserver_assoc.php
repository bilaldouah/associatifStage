<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
   
    <title>Reservation</title>
    <?php
        SESSION_START();
        
        if(!isset($_SESSION['login']))
        {
          header("Location:login.php");
        }
       
        require "bd.php";
        $eror="";
        $id=$_GET['id_salle'];
        $id_assoc=$_GET["id_assoc"];
        $query="SELECT * FROM stage.salle WHERE  id=$id";
        $stat=$con->prepare($query);
        $stat->execute();
        $data=$stat->fetch();
        
  
        $query_="SELECT * FROM stage.association WHERE  idAssociation=$id_assoc";
        $stat_=$con->prepare($query_);
        $stat_->execute();
        $data_=$stat_->fetch();
        $temp=$_SESSION['time'];
        $req="SELECT count(*) as nbr FROM stage.reservation where DATE(date_de_rese) like  DATE('$temp') and accesoir = 'oui' ";

        if(isset($_GET["statut"])){
        $sta=$_GET['statut'];
        $req="SELECT  count(*) as nbr FROM stage.reservation where DATE(date_de_rese) like  DATE('$temp') and accesoir = 'oui' and statut='$sta'";
        }

        $stat0=$con->prepare($req);
        $stat0->execute();
        $data0=$stat0->fetch();
        $nbr_=$data0['nbr'];
        

        if(isset($_POST["nombre"])){
          $nombre=$_POST["nombre"];
          $statut=$_POST["statu"];
          $heure =$_POST["heure"];
          $date=$_SESSION['time']." ".$heure;
          $proj=$_POST["proj"];
          $hall=$_POST["hall"];
          $query="INSERT INTO reservation values (NULL,:idsalle,:idAssociation,:date_rev,:statut,:capacite,:proj,:hall)";
              $stat=$con->prepare($query);
              $stat->execute(
                array(':idsalle'=>$_GET["id_salle"],':idAssociation'=>$_GET["id_assoc"],
                ':date_rev'=>$date,':statut'=>$statut,':capacite'=>$nombre,
                ':proj'=>$proj,':hall'=>$hall)
              );
             
              
              //header("Location:reservation.php");

            }
            require "menu.html";

        
        
    ?>
</head>
<body>
<div class="  d-flex justify-content-center w-100 mt-5">

<form method="post" class="mb-5  py-5 w-50" id="formContent" action="#">
    
    <label class="d-flex flex-column text-right mr-5  text-info size">Reservation date
</label>
        <input type="text"  readonly="readonly" value="<?= $_SESSION['time'] ?>" />



    
    <label class="d-flex flex-column text-right mr-5  text-info size">Booking time
</label>
        <input type="time" placeholder="Heure De Reservation" name="heure" required/>
      


    <label class="d-flex flex-column text-right mr-5  text-info size">Room name and number </label>
        <input type="text"  readonly="readonly" value="<?= $data['nomSalle']." / ".$data['numeroSalle']?>"  />
        


    <label class="d-flex flex-column text-right mr-5  text-info size">Association name </label>
          <input type="text"  readonly="readonly" value="<?= $data_['nom']?>"  />



    <label class="d-flex flex-column text-right mr-5  text-info size">The number of people </label>
        <input type="text" name="nombre" required />



    <label class="d-flex flex-column text-right mr-5  text-info size">  Hall </label>
        <select name="hall" class="text-center">
           
                    <option value='non'> without hall</option>
                    <option value="oui"> with Hall</option>
                    
           
        </select>

    <label class="d-flex flex-column text-right mr-5  text-info size mt-3">  Data show</label>        
    <?php
        if($nbr_>=2)
        {
            
    ?>
            <input type="text"  readonly="readonly" value="جميع أجهزة العرض محجوزة" />
    <?php
        }
        else
        {
    ?>
        <select name="proj" class="text-center">
           
                    <option value='non'> with data show</option>
                    <option value="oui">without data show </option>
                    
           
        </select>
        <?php
        }

    ?>        
    <label class="d-flex flex-column text-right mr-5  text-info size mt-3">day period </label>
        <select name="statu" class="text-center">
            <?php
                 if(!isset($_GET['statut']))
                 {
             ?>
                    <option value='Jour'>All day</option>
                    <option value="Matin">Morning</option>
                    <option value="Soir">Evening</option>
            <?php
                 }
                 else
                 {
            ?>
                   <option value='<?=$_GET['statut']?>'><?=$_GET['statut']?></option>
            <?php 
                }
            ?>
        </select>
        



    <input type="submit" class=" mt-5" value="valider">

  </form>
</div>
</div>

</body>
</html>