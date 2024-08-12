<?php
    include "config.php";
    if (empty($_FILES["new-image"]["name"])) {
        $file_name = $_POST["old-image"];
    }else {
        $error = array();

        $file_name = $_FILES['new-image']['name'];
        $file_size = $_FILES['new-image']['size'];
        $file_tmp = $_FILES['new-image']['tmp_name'];
        $file_type = $_FILES['new-image']['type'];
        $file_ext = strtolower(end(explode('.',$file_name)));
        $extention = array("jpeg","jpg","png");

        if (empty($error) == true) {
            move_uploaded_file($file_tmp,"./upload/".$file_name);
        }else {
            print_r($error); 
            die();
        };
    };
    $sql = "UPDATE post SET title='{$_POST['post_title']}', description='{$_POST['postdesc']}' , category={$_POST['category']} ,post_img='{$file_name}'
    WHERE post_id = {$_POST['post_id']}";

    if (mysqli_query($connect,$sql)) {
        header("location: {$host}/admin/post.php");
    }else {
        echo "query Faild";
    };
?>