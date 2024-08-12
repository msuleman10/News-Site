<?php
    include "config.php";
    session_start();

    if (isset($_FILES['fileToUpload'])) {
        $error = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_ext = explode('.',$file_name);
        $extention = array("jpeg","jpg","png","webp");

        
        if (empty($error) == true) {
            move_uploaded_file($file_tmp,"./upload/".$file_name);
        }else {
            print_r($error); 
            die();
        };
    };
    
    $title = mysqli_real_escape_string($connect,$_POST["post_title"]);
    $description = mysqli_real_escape_string($connect,$_POST["postdesc"]);
    $category = mysqli_real_escape_string($connect,$_POST["category"]);
    $date = date("d M, Y");
    $author = $_SESSION["user_id"];

    $sql = "INSERT INTO post(title , description , category , post_date , author , post_img) VALUE ('{$title}' , '{$description}' , {$category} , '{$date}' , {$author} , '{$file_name}');";
    $sql.= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

    if (mysqli_multi_query($connect,$sql)) {
        header("location: {$host}/admin/post.php");
    }else {
        echo "query Faild";
    }
?>