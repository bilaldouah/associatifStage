<?php
    SESSION_START();
    if(isset($_SESSION['login']))
    {   
        require "bd.php";
        $id = $_GET['id'];
        $query="DELETE FROM reservation WHERE  id=:id";
        $stat=$con->prepare($query);
        $stat->execute(array(":id"=>$id));
        header("Location:reservation.php");
    }

?>