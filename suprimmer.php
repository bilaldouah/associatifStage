<?php
 SESSION_START();
 if(isset($_SESSION['login']))
 {  
$id=$_GET["id"];
include "bd.php";
$query="DELETE from association where idAssociation=:id";
$stat=$con->prepare($query);
$stat->execute(array(":id"=>$id));
header("Location:assosciation.php");
 }
?>