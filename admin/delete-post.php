<?php
    include "config.php";

    $post_id = $_GET["ppage"];
    $cat_id = $_GET["pcat"];

    $sql2 = "SELECT * FROM post WHERE post_id = {$post_id}";
    $result = mysqli_query($connect,$sql2);
    $row = mysqli_fetch_assoc($result);
    unlink("upload/".$row["post_img"]);

    
    $sql = "DELETE FROM post WHERE post_id = {$post_id};";
    $sql.= "UPDATE category SET post = post-1 WHERE category_id = {$cat_id}";

    if (mysqli_multi_query($connect,$sql)) {
        header("location: {$host}/admin/post.php");
    }else {
        echo "query faild";
    };
?>