<?php
    SESSION_START();
    if(isset($_SESSION['login']))
    {   
        require "bd.php";
        $id = $_GET['id'];
        $query="DELETE FROM salle WHERE  id=:id";
        $stat=$con->prepare($query);
        $stat->execute(array(":id"=>$id));
        header("Location:salle.php");
    }

?>