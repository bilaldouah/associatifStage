<?php
    SESSION_START();
    if(isset($_SESSION['login']))
    {   
        require "bd.php";
        $id = $_GET['id'];
        $query="DELETE FROM province WHERE  idProvince=:id";
        $stat=$con->prepare($query);
        $stat->execute(array(":id"=>$id));
        header("Location:province.php");
    }

?>