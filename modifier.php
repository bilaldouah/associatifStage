<?php
SESSION_START();
if(!isset($_SESSION['login']))
{
  header("Location:login.php");
}
include "bd.php";
$id=$_GET["id"];
$idPro=$_GET["idProvince"];
$idThe=$_GET["idTheme"];
$statusAsso=$_GET["adehsion"];
$activee=$_GET["active"];


    $query="SELECT nom,nomThem,nomProvince,nomPresident,telefix,telegsm,adresse,siteWeb,activeOuNon,status,email,date_de_creation,date_dadession,nomfr,cin FROM theme inner join association  on theme.idTheme=association.idTheme inner join province on association.idProvince=province.idProvince WHERE idAssociation=:idAssociation";
    $stat=$con->prepare($query);
    $stat->execute(array(":idAssociation"=>$id));
    $data=$stat->fetchall(PDO::FETCH_NUM);

    $nom=$data[0][0];
    $nomThem=$data[0][1];
    $nomProvince=$data[0][2];
    $nomPresident=$data[0][3];
    $telefix=$data[0][4];
    $telegsm=$data[0][5];
    $adresse=$data[0][6];
    $siteWeb=$data[0][7];
    $activeOuNon=$data[0][8];
    $status=$data[0][9];
    $email=$data[0][10];
    $date_de_creation=$data[0][11];
    $date_dadession=NULL;
    if($data[0][12] != '0000-00-00')
    {
      $date_dadession=$data[0][12];
    }
    $nomfr=$data[0][13];
    $cin=$data[0][14];

if(isset($_POST["nom"]))
{

  $nom=$_POST["nom"];
  $nomPresident=$_POST["nomPresident"];
  $telfix=$_POST["telfix"];
  $telgsm=$_POST["telgsm"];
  $adress=$_POST["adress"];
  $siteWeb=$_POST["siteWeb"];
  $email=$_POST["email"];
  $idProvince=$_POST["idProvince"];
  $idTheme=$_POST["idTheme"];
  $adehesion=$_POST["adehesion"];
  $dateAdehsion=$_POST["dateAdehsion"];
  $datecreat=$_POST["datecreation"];
  $acitve=$_POST["acitve"];
  $nomfr=$_POST["nomfr"];
  $cin=$_POST["cin"];

  if(!empty($_POST['province']))
  {  
    $province=$_POST["province"];
    $queryProvince="INSERT INTO province (nomProvince) values(:nomProvince)";
    $statProvince=$con->prepare($queryProvince);
    $statProvince->execute(array(":nomProvince"=>$province));
  
    $querySelectIdProvince="SELECT idProvince FROM province WHERE nomProvince=:nomProvince";
    $statSelectIdProvince=$con->prepare($querySelectIdProvince);
    $statSelectIdProvince->execute(array(":nomProvince"=>$province));
    $dataSelectIdProvince =$statSelectIdProvince->fetchall(PDO::FETCH_NUM);
    $idProvince= $dataSelectIdProvince[0][0];  
  
   
  
   
    }
    if(!empty($_POST['theme']))
    {  
   
      $theme=$_POST["theme"];
      $query="INSERT INTO theme (nomThem) values(:nomThem)";
      $stat=$con->prepare($query);
      $stat->execute(array(":nomThem"=>$theme));
      
      $querySelectId="SELECT idTheme FROM theme WHERE nomThem=:nomThem";
      $statSelectId=$con->prepare($querySelectId);
      $statSelectId->execute(array(":nomThem"=>$theme));
      $dataSelectId =$statSelectId->fetchall(PDO::FETCH_NUM);
      $idTheme= $dataSelectId[0][0];
         
    }
    
      $queryUpdate="UPDATE association set nom=:nom,idProvince=:idProvince,idTheme=:idTheme,nomPresident=:nomPresident,
      telefix=:telefix,telegsm=:telegsm,adresse=:adresse,siteWeb=:siteWeb,activeOuNon=:activeOuNon,status=:status,
      email=:email,date_de_creation=:date_de_creation,date_dadession=:date_dadession,nomfr=:nomfr,cin=:cin 
      where  idAssociation=:idAssociation";

      $stats=$con->prepare($queryUpdate);
      $stats->execute(array(":nom"=>$nom,":idProvince"=>$idProvince,":idTheme"=>$idTheme,":nomPresident"=>$nomPresident,
      ":telefix"=>$telfix,":telegsm"=>$telgsm,":adresse"=>$adress,":siteWeb"=>$siteWeb,":activeOuNon"=>$acitve,
      ":status"=>$adehesion,":email"=>$email,":date_de_creation"=>$datecreat,":date_dadession"=>$dateAdehsion,
      ":idAssociation"=>$id,":nomfr"=>$nomfr,":cin"=>$cin));
      header("Location:assosciation.php");
    

   
}
include "menu.html";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body onload="loaded()">
  <div class="h-25 p-3"></div>
   
<div class=" d-flex justify-content-center  w-75 m-auto">

    <!-- Tabs Titles -->

    <!-- Icon -->
    <form method="post" class="mb-5  py-5" id="formContent" action="#">
    <div class="d-flex">
    <div class="col-6">
    <label class="d-flex flex-column text-right mr-5  text-info size">البريد الإلكتروني</label>  
                    <input type="email"  class="fadeIn second" name="email" placeholder="البريد الإلكتروني" value="<?= $email?>" >
   

    
                  <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">تاريخ تأسيس</label>  
                  <input type="date"  class="fadeIn second" name="datecreation" placeholder="تاريخ تأسيس" value="<?= $date_de_creation?>" >

      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">العمالات و الأقاليم</label>  
      <select name="idProvince" id="province" onchange="myFunctionProvince(this)">
      <option disabled="disabled"  value="" class="text-center">العمالات و الأقاليم</option>
        <?php
        $queryProvince="SELECT * from province";
        $statement=$con->prepare($queryProvince);
        $statement->execute();
        $data =$statement->fetchall();
        foreach($data as $province)
        {
        $selectedProvince="";
      if($province["idProvince"]==$idPro)
        {
          $selectedProvince="selected";
       }
         
        
            ?>
            <option <?=$selectedProvince?>  value="<?=$province["idProvince"]?>" class="text-center"><?=$province["nomProvince"]?></option>
            
              <?php
        }
        ?>
        <option value="أخرى" class="text-center">أخرى</option>
      </select>
      <input type="hidden" id="autreProvince"  class="fadeIn second" name="province" placeholder="أخرى" value="" >
      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">التخصصات</label>  
  
      <select name="idTheme" id="theme" onchange="myFunctionTheme(this)">
      <option disabled="disabled"  value="" class="text-center">التخصصات</option>
        <?php
        
            $queryTheme="SELECT * from theme";
            $statementqueryTheme=$con->prepare($queryTheme);
            $statementqueryTheme->execute();
            $dataTheme =$statementqueryTheme->fetchall();

        foreach($dataTheme as $theme)
        {
          $selectedTheme="";
          if($theme["idTheme"]==$idThe)
          {
            $selectedTheme="selected";
          }
            ?>
            
            <option <?=$selectedTheme?> value="<?=$theme["idTheme"]?>" class="text-center"><?=$theme["nomThem"]?></option>
              <?php
        }
        ?>
        <option value="أخرى" class="text-center">أخرى</option>
      </select>
       <?php
        $selectedAdehsion="";
        $selectedNonAdehsion="";
       if("منخرط"==$statusAsso)
       {
         $selectedAdehsion="selected";
       }
       if("غير منخرط"==$statusAsso)
       {
         $selectedNonAdehsion="selected";
       }
       ?>
      <input type="hidden" id="autreTheme"  class="fadeIn second" name="theme" placeholder="أخرى" value="" required>
      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">الإنخراط </label>
      <select  id="adehesion" name="adehesion" onchange="myFunctionAdehsion(this)">
            <option <?=$selectedAdehsion?> value="منخرط" class="text-center">منخرط</option>
            <option <?=$selectedNonAdehsion?> value="غير منخرط" class="text-center">غير منخرط</option>
          
      </select>
<div id="dateAdehsion" >
<label class="d-flex flex-column text-right mr-5 mt-3 text-info size">تاريخ الإنخراط</label>
      <input type="hidden"  class="fadeIn second" id="dateAdehsion_" name="dateAdehsion" placeholder="تاريخ الإنخراط" value="<?= $date_dadession?>"  max="<?= date('Y-m-d') ?>" required>
</div>


      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size" >نشيطة أو غير نشيطة </label>
      <select name="acitve" id="active" >
      <?php
       $active="";
       $Nonactive="";
       if("نشيطة"==$activee)
       {
         $active="selected";
       }
       if("غير نشيطة"==$activee)
       {
         $Nonactive="selected";
       }
       ?>
            <option <?=$active?>  value="نشيطة"  class="text-center">نشيطة</option>
            <option  <?=$Nonactive?> value="غير نشيطة"  class="text-center">غير نشيطة</option>
          
      </select>

                  </div>
             
                <div class="border">

</div>
     <div class="col-6">  
                    <label class="d-flex flex-column text-right mr-5  text-info size"> nom d'association</label>  
                    <input type="text"  class="fadeIn second " name="nomfr" placeholder=" nom d'association " value="<?=$nomfr ?>" required>
        
                    <label class="d-flex flex-column  text-right mr-5 text-info size">إسم الجمعية</label>  
                    <input type="text"  class="fadeIn second" name="nom" placeholder="إسم الجمعية" value="<?= $nom?>" >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">إسم الرئيس</label>  
                    <input type="text"  class="fadeIn second" name="nomPresident" placeholder="إسم الرئيس" value="<?= $nomPresident?>" >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size"> CIN</label>  
                    <input type="text"  class="fadeIn second" name="cin" placeholder="CIN " value="<?=$cin ?>"required >

                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">1 الهاتف</label>  
                    <input type="tel"  class="fadeIn second" name="telfix" placeholder="الهاتف" value="<?= $telefix?>" >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">2 الهاتف</label>  
                    <input type="tel"  class="fadeIn second" name="telgsm" placeholder="الهاتف" value="<?= $telegsm?>" >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">العنوان  </label>
                    <input type="text"  class="fadeIn second" name="adress" placeholder="العنوان" value="<?= $adresse?>" >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">الموقع الإلكتروني</label>  
                    <input type="text"  class="fadeIn second" name="siteWeb" placeholder="الموقع الإلكتروني" value="<?= $siteWeb?>" >
               

                   
    </div>
    </div>
    <input type="submit" class="fadeIn fourth mt-5" value="modifier">
    </form>

</div>

</body>
</html>
<script>
function myFunctionTheme(themes) {

 var e= themes[themes.selectedIndex].text;

  if(e=='أخرى')
  {
    document.getElementById('autreTheme').type = 'text';
  }
  else
  {
    document.getElementById('autreTheme').type = 'hidden';
  }
  
}
function myFunctionProvince(provinces) {
 var x= provinces[provinces.selectedIndex].text;

  if(x=='أخرى')
  {
    document.getElementById('autreProvince').type = 'text';
  }
  else
  {
    document.getElementById('autreProvince').type = 'hidden';
  }
}

function myFunctionAdehsion() {
  var adehsion= document.getElementById('adehesion');
 var y= adehsion[adehsion.selectedIndex].text;
  if(y=='غير منخرط')
  {
    document.getElementById('dateAdehsion').style.display = 'none';
    document.getElementById('dateAdehsion_').type = 'hidden';

  }
  else
  {
    document.getElementById('dateAdehsion').style.display = 'block';
    document.getElementById('dateAdehsion_').type = 'date';

  }
}
 
  
function loaded()
{
myFunctionAdehsion();
}


 </script>
