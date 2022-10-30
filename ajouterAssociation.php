<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Association</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
SESSION_START();
 if(!isset($_SESSION['login']))
 {
   header("Location:login.php");
 }
require "bd.php";
$nom="";
$nomPresident="";
$telfix="";
$telgsm="";
$adress="";
$siteWeb="";
$email="";
$province="";
$theme="";
$adehesion="";
$dateAdehsion="";
$datecreat="";
$province="";
$acitve="";
$aze="";
$nomfr="";
$cin="";

$querynbr="SELECT MAX(cast(SUBSTRING_INDEX(TRIM(adresse), ' ', -1) AS INT ) ) as nbr FROM stage.association where SUBSTRING(adresse, 1, 28) like 'شارع العرفان حي ايريس – وجدة';";
$statnbr=$con->prepare($querynbr);
$statnbr->execute();
$datanbr=$statnbr->fetch();
$max=$datanbr['nbr'];

if(isset($_POST['nom'])&& isset($_POST['theme'])&&isset($_POST['province']))
{
  $aze=$_POST["locale"];
  $bool=1;
  $bool2=1;
  $nom=$_POST["nom"];
  $nomPresident=$_POST["nomPresident"];
  $telfix=$_POST["telfix"];
  $telgsm=$_POST["telgsm"];
  $adress=$_POST["local"]." ".$_POST["locale"];
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
    if(empty($_POST['local']))
    {  
      $adress=$_POST["locale"];
      $bool=0;    
      }
    
    if($bool==1){
          $queryadd="SELECT adresse FROM association where adresse = :addresse";
          $statadd=$con->prepare($queryadd);
          $statadd->execute(array(":addresse"=>$adress));
          $data_=$statadd->fetchAll();
          if (count($data_) != 0)
          {
            echo "<script>alert('adresse deja exist');</script>"; 
            $bool2=0;
             
          }
        }
        if($bool2==1){
              $query="INSERT INTO association (nom,idProvince,idTheme,nomPresident,telefix,telegsm,adresse,siteWeb,date_dadession,activeOuNon,status,email,date_de_creation,nomfr,cin)
                      values(:nom,:idProvince,:idTheme,:nomPresident,:telefix,:telegsm,:adresse,:siteWeb,:dateDadehesion,:activeOuNon,:status,:email,:date_de_creation,:nomfr,:cin)";
              $stat=$con->prepare($query);
              $stat->execute(array(":nom"=>$nom,":idProvince"=>$idProvince,":idTheme"=>$idTheme,
                    ":nomPresident"=>$nomPresident,":telefix"=>$telfix,":telegsm"=>$telgsm,":adresse"=>$adress,
                    ":siteWeb"=>$siteWeb,":dateDadehesion"=>$dateAdehsion,":activeOuNon"=>$acitve,":status"=>$adehesion,
                    ":email"=>$email,":date_de_creation"=>$datecreat,":nomfr"=>$nomfr,":cin"=>$cin));
              
              if(isset($_GET["id_salle"]) && !isset($_GET["statut"])){

                $id_salle=$_GET['id_salle'];
                  header("Location:choisir_assoc.php?id_salle=$id_salle");
              }
              if(isset($_GET["id_salle"]) and isset($_GET["statut"])){

                $id_salle=$_GET['id_salle'];
                $statut=$_GET["statut"];
                header("Location:choisir_assoc.php?id_salle=$id_salle&statut=$statut");
              }
              if(!isset($_GET["id_salle"]) and !isset($_GET["statut"])){
                header("Location:assosciation.php");  
              }
          }
        }
        require "menu.html";

?>

<body>
  <div class="h-25 p-3"></div>

<div class="  d-flex justify-content-center  w-75 m-auto">

 

    <form method="post" class="mb-5  py-5" id="formContent" action="#">
    <div class="d-flex">
    <div class="col-6">
    <label class="d-flex text-right mr-5  flex-column text-info size">البريد الإلكتروني</label>  
                    <input type="email"  class="fadeIn second" name="email" placeholder="البريد الإلكتروني" value="<?=$email ?>" >
   

    
      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size"> تاريخ تأسيس</label>  
      <input type="date"  class="fadeIn second" name="datecreation" placeholder="تاريخ تأسيس" value="<?=$datecreat ?>" required>

      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">العمالات و الأقاليم</label>  
      <select name="idProvince" id="province" onchange="myFunctionProvince(this)" required>
        <option value="" class="text-center">العمالات و الأقاليم</option>
        <?php
        $queryProvince="SELECT * from province";
        $statement=$con->prepare($queryProvince);
        $statement->execute();
        $data =$statement->fetchall();
        foreach($data as $province)
        {
            ?>
            <option value="<?=$province["idProvince"]?>" class="text-center"><?=$province["nomProvince"]?></option>
            
              <?php
        }
        ?>
        <option value="أخرى" class="text-center">أخرى</option>
      </select>
      <input type="hidden" id="autreProvince"  class="fadeIn second" name="province" placeholder="أخرى" value="" required>
      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">التخصصات</label>  
  
      <select name="idTheme"  onchange="myFunctionTheme(this)" required>
        <option value="" class="text-center">التخصصات</option>
        <?php
        
            $queryTheme="SELECT * from theme";
            $statementqueryTheme=$con->prepare($queryTheme);
            $statementqueryTheme->execute();
            $dataTheme =$statementqueryTheme->fetchall();

        foreach($dataTheme as $theme)
        {
            ?>
            <option value="<?=$theme["idTheme"]?>" class="text-center"><?=$theme["nomThem"]?></option>
              <?php
        }
        ?>
        <option value="أخرى" class="text-center">أخرى</option>
      </select>
       
      <input type="hidden" id="autreTheme"  class="fadeIn second" name="theme" placeholder="أخرى" value="" required>

      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">الإنخراط </label>

      <select name="adehesion" onchange="myFunctionAdehsion(this)" required>
      
            <option value="" class="text-center"> الإنخراط  </option>
            <option value="غير منخرط" class="text-center">غير منخرط</option>
            <option value="منخرط" class="text-center">منخرط</option>

      </select>
<div id="adehsion" style="display: none;">
<label class="d-flex flex-column text-right mr-5 mt-3 text-info size">تاريخ الإنخراط</label>
      <input type="hidden"  class="fadeIn second" id="dateAdehsion_" name="dateAdehsion" placeholder="تاريخ الإنخراط" value="" required max="<?= date('Y-m-d') ?>">
</div>


      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">نشيطة أو غير نشيطة </label>
      <select name="acitve" required>
            <option value="" class="text-center">نشيطة أو غير نشيطة</option>
            <option value="نشيطة" class="text-center">نشيطة</option>
            <option value="غير نشيطة" class="text-center">غير نشيطة</option>
          
      </select>

      <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">العنوان  </label>

<select name="local" onchange="myFunctionLocal(this)" required>

  <option value="شارع العرفان حي ايريس – وجدة  " class="text-center">مقر بالفضاء</option>
  <option value="" class="text-center">عنوان</option>

</select>
<input type="number" id="local" readonly="readonly" class="fadeIn second" name="locale" value="<?=$max+1?>" placeholder="الرقم" required>


    </div>
             <div class="border">

             </div>
                
     <div class="col-6">
     <label class="d-flex flex-column text-right mr-5  text-info size"> nom d'association</label>  
                    <input type="text"  class="fadeIn second " name="nomfr" placeholder=" nom d'association " value="<?=$nomfr ?>" required>
                
     <label class="d-flex flex-column text-right mr-5  text-info size">إسم الجمعية</label>  
                    <input type="text"  class="fadeIn second " name="nom" placeholder="إسم الجمعية" value="<?=$nom ?>" required>
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">إسم الرئيس</label>  
                    <input type="text"  class="fadeIn second" name="nomPresident" placeholder="إسم الرئيس" value="<?=$nomPresident ?>"required >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size"> CIN</label>  
                    <input type="text"  class="fadeIn second" name="cin" placeholder="CIN " value="<?=$cin ?>"required >
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">1 الهاتف</label>  
                    <input type="tel" pattern="^0[5-7][0-9]{8}" class="fadeIn second" name="telfix" placeholder="الهاتف" value="<?=$telfix ?>" required>
                    
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">2 الهاتف</label>  
                    <input type="tel" pattern="^0[5-7][0-9]{8}" class="fadeIn second" name="telgsm" placeholder="الهاتف" value="<?=$telgsm ?>" >

                         
                    <label class="d-flex flex-column text-right mr-5 mt-3 text-info size">الموقع الإلكتروني</label>  
                    <input type="text"  class="fadeIn second" name="siteWeb" placeholder="الموقع الإلكتروني" value="<?=$siteWeb ?>" >
                 
     

                   

    </div>
    </div>
          <input type="submit" class="fadeIn fourth mt-5" value="ajouter">
    </form>
    </div>




</body>
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

  function myFunctionAdehsion(adehsion) {
 var y= adehsion[adehsion.selectedIndex].text;

  if(y!='منخرط')
  {
    document.getElementById('adehsion').style.display = 'none';
    document.getElementById('dateAdehsion_').type = 'hidden';

  }
  else
  {
    document.getElementById('dateAdehsion_').type = 'date';
    document.getElementById('adehsion').style.display = 'block';

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

  function myFunctionLocal(local) {
 var z= local[local.selectedIndex].text;

 if(z=='عنوان')
 {
    document.getElementById('local').type = 'text';
    document.getElementById('local').placeholder = 'العنوان';
    document.getElementById('local').value = "<?=$aze?>";
    document.getElementById('local').readOnly =false;

  }
  else{
    document.getElementById('local').type = 'number';
    document.getElementById('local').placeholder = 'الرقم';
    document.getElementById('local').value = <?=$max+1?>;
    document.getElementById('local').readOnly =true;



  }
  

  
}


 </script>
 </html>
