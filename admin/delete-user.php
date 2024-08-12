<?php
    include "config.php";

    $user_id = $_GET["id"];
    $sql = "DELETE FROM user WHERE user_id='{$user_id}'";
        
    if (mysqli_query($connect,$sql)) {
        header("location: {$host}/admin/users.php");
    };
?>