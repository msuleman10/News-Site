<?php
    include "config.php";

    $category_id = $_GET["cpage"];
    $sql = "DELETE FROM category WHERE category_id = '{$category_id}'";

    if (mysqli_query($connect,$sql)) {
        header("location: {$host}/admin/category.php");
    };
?>