<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <title>Association</title>
    
</head>
<?php
SESSION_START();
if(!isset($_SESSION['login']))
{
  header("Location:login.php");
}
require "menu.html";
require "bd.php";
if(!isset($_GET['id']))
{
  $id="";
}
else
{
  $id = $_GET['id'];
}

if(!isset($_GET['idTheme']))
{
  $idTheme="";
}
else
{
  $idTheme = $_GET['idTheme'];
}
if(!isset($_GET['status']))
{
  $status="";
}
else
{
  $status = $_GET['status'];
}
if(!isset($_GET['active']))
{
  $active="";
}
else
{
  $active = $_GET['active'];
}
  


 

?>

<body onload="onload()">

<div class="mw-100 container mt-4  ">
<div class="d-flex mw-100 justify-content-between">
<div class="w-100">
<?php
  if(isset($_GET["idTheme"]))
  {
?>
<a class="btn btn-primary m-1" href="information_list.php?idTheme=<?= $_GET["idTheme"]?>&id=<?= $_GET["id"]?>&active=<?= $_GET["active"]?>&status=<?= $_GET["status"]?>"> 
    <img src="image/imp.png" style="width:30px">
</a>
<?php
  }
  else{
    ?>
<a class="btn btn-primary m-1" href="information_list.php"> 
    <img src="image/imp.png" style="width:30px">
</a>
   <?php 
  }
  
?>

 
<select class="m-2" value="<?=$id?>" style="width:15%" name="idProvince" id="province"  onchange="optionChanged()">
 
 <option  value="" class="text-center">All Provinces</option>
  <?php


  $queryProvince="SELECT * from province";
  $statementProvince=$con->prepare($queryProvince);
  $statementProvince->execute();
  $dataProvince =$statementProvince->fetchall();
  foreach($dataProvince as $province)
  {
      ?>
      <option value="<?=$province["idProvince"]?>" class="text-center"><?=$province["nomProvince"]?></option>
      
        <?php
      
  }
  
  ?>

</select>




<select value="<?=$idTheme?>" style="width:15%" name="idTheme" id="theme"  onchange="optionChanged()">

<option value="" class="text-center">All specialties </option>
<?php


$queryTheme="SELECT * from theme";
$statementTheme=$con->prepare($queryTheme);
$statementTheme->execute();
$dataTheme =$statementTheme->fetchall();
foreach($dataTheme as $theme)
{
?>
<option value="<?=$theme["idTheme"]?>" class="text-center"><?=$theme["nomThem"]?></option>

  <?php

} 


?>
</select>
<select class="m-2" value="<?=$status?>" style="width:15%" name="idStatus" id="status"  onchange="optionChanged()">

<option  value="" class="text-center"> Subscribed or unsubscribed </option>
<option value="منخرط" class="text-center">Subscribed</option>
<option  value="غير منخرط" class="text-center">unsubscribed</option>

</select>

</select>
<select class="m-2" value="<?=$active?>" style="width:15%" name="idActive" id="active"  onchange="optionChanged()">

<option  value="" class="text-center">Active or inactive</option>
<option    value="نشيطة"  class="text-center">Active</option>
<option   value="غير نشيطة"  class="text-center">inactive</option>


</select>
</div>
<div >
    <a  href="ajouterAssociation.php" name="botton" class="mr-3 plus"> <img src="image/icons8-add-50.png" style="width:55px"></a>
</div>
</div>
<table id="example" class="table table-striped table-bordered mw-100 police " style="width:100%">

<?php
   

$provinceQeury="true";
$themeQeury="true";
$statusQeury="true";
$activeQeury="true";
if(!empty($id)){$provinceQeury="association.idProvince='$id'";} 
if(!empty($idTheme)){$themeQeury="association.idTheme='$idTheme'";} 
if(!empty($status)){ $statusQeury="association.status='$status'";}
if(!empty($active)){$activeQeury="association.activeOuNon='$active'";} 

$queryAll="SELECT * FROM theme inner join association  on theme.idTheme=association.idTheme 
inner join province on association.idProvince=province.idProvince where {$provinceQeury}
and {$themeQeury} and {$statusQeury} and {$activeQeury} ";

$stmtAll=$con->prepare($queryAll);
$stmtAll->execute();
$data =$stmtAll->fetchall();  


?>



        <thead>
       
        <tr>
        
        <td class="text-center">action</td>
        <td class="text-center">subscription date</td>
        <td class="text-center">Intervention field</td>
          <td class="text-center">Email</td>
          <td class="text-center"> Phone</td>
          <td class="text-center">President name</td>
          <td class="text-center">Addres</td>
          <td class="text-center">Province</td>
          <td class="text-center">Foundation date</td>    
          <td class="text-center">Association name</td>
 
        </tr>
        </thead>
     
        <tbody >
        
        <?php     

        foreach($data as $row)
        {
            ?>
          <tr>
            <td class="d-flex justify-content-center">
              <a class="btn btn-danger m-1" href="suprimmer.php?id=<?= $row["idAssociation"]?>" onclick="return confirm('vous étes sur de suprimmer cette assoctiation')"> <img src="image/icons8-delete-67.png"style="width:25px"></a> 
              <a class="btn btn-warning m-1" href="modifier.php?id=<?= $row["idAssociation"]?>&idProvince=<?= $row["idProvince"]?>&idTheme=<?= $row["idTheme"]?>&adehsion=<?= $row["status"]?>&active=<?= $row["activeOuNon"]?>" ><img src="image/icons8-development-64.png" style="width:25px"></a>
            </td>
            <?php
              if($row["date_dadession"] == '0000-00-00')
              {
            ?>

              <td class="text-center"></td>
            <?php
              }
              else
              {
            ?>  
              <td class="text-center"><?=$row["date_dadession"]?></td>  
            <?php
             }
            ?> 
            <td class="text-center"><?=$row["nomThem"]?></td>
            <td class="text-center"><?=$row["email"]?></td>
            <td class="text-center"><?=$row["telefix"]?></td>
            <td class="text-center"><?= $row["nomPresident"] ?></td>
            <td class="text-center"><?=$row["adresse"]?></td>
            <td class="text-center"><?=$row["nomProvince"]?></td>
            <td class="text-center"><?=$row["date_de_creation"]?></td>
            <td class="text-center"><?=  $row["nom"] ?></td>
      

     
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
<script type="text/javascript">
function optionChanged()
{
              var Theme = document.getElementById('theme');
              var Province = document.getElementById('province');
              var active = document.getElementById('active');
              var status = document.getElementById('status');
              
              
                    var IdTheme =Theme[Theme.selectedIndex].value;
                    var IdProvince =Province[Province.selectedIndex].value;
                    var idActive =active[active.selectedIndex].value;
                    var idStatus =status[status.selectedIndex].value;
                      
                        window.location.href = "assosciation.php?idTheme="+IdTheme+"&id="+IdProvince+"&active="+idActive+"&status="+idStatus;
}
 
    function onload()
    {

      var province = document.getElementById('province');
      var id = province.getAttribute('value'); 

              for(var i=0;i<province.options.length;i++){
                    if(province.options[i].value==id)   province.selectedIndex=i;

                    }
 
      var selectIdTheme = document.getElementById('theme');
      var idTheme = selectIdTheme.getAttribute('value'); 

              for(var i=0;i<selectIdTheme.options.length;i++){
                if(selectIdTheme.options[i].value==idTheme)   selectIdTheme.selectedIndex=i;

              }
              var selectActive = document.getElementById('active');
      var active = selectActive.getAttribute('value'); 

              for(var i=0;i<selectActive.options.length;i++){
                if(selectActive.options[i].value==active)   selectActive.selectedIndex=i;

              }
              var selectStatus = document.getElementById('status');
      var status = selectStatus.getAttribute('value'); 

              for(var i=0;i<selectStatus.options.length;i++){
                if(selectStatus.options[i].value==status)   selectStatus.selectedIndex=i;
  

              }
 
             
 
    };
</script>