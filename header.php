<?php
    include "config.php";
    $page = basename($_SERVER["PHP_SELF"]);
    switch ($page) {
        case 'single.php':
            if(isset($_GET["pj"])){
                $sql_title = "SELECT * FROM post WHERE post_id ={$_GET['pj']} ";
                $result_title = mysqli_query($connect,$sql_title);
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title["title"];
            }else {
                $page_title = "no post found"; 
            };
            break;
        case 'search.php':
            if(isset($_GET["search"])){
                
                $page_title = $_GET["search"];
            }else {
                $page_title = "no search result found"; 
            };
            break;
        case 'category.php':
            if(isset($_GET["cid"])){
                $sql_title = "SELECT * FROM category WHERE category_id ={$_GET['cid']} ";
                $result_title = mysqli_query($connect,$sql_title);
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title["category_name"];
            }else {
                $page_title = "no category found"; 
            };
            break;
        case 'author.php':
            if(isset($_GET["apj"])){
                $sql_title = "SELECT * FROM user WHERE user_id ={$_GET['apj']} ";
                $result_title = mysqli_query($connect,$sql_title);
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title["username"];
            }else {
                $page_title = "no author found"; 
            };
            break;
        
        default:
            $page_title = "Today";
            break;
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title ;?> News</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
                <a href="index.php" id="logo"><img src="images/news.jpg"></a>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    include "config.php";
                    if (isset($_GET["cid"])) {
                        $cat = $_GET["cid"];
                    };

                    $sql = "SELECT * FROM category WHERE post > 0";
                    $result = mysqli_query($connect,$sql);
                    if (mysqli_num_rows($result) > 0) {
                        $activ = "";
                ?>
                <ul class='menu'>
                    <li><a href="<?php echo $host;?>"> HOME</a></li>
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            if(isset($_GET["cid"])){
                                if ($row['category_id'] == $cat){
                                    $activ = "active";
                                }else {
                                    $activ = "";
                                };
                            };
                           
                            echo "<li><a class='{$activ}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                        };   
                    ?>
                </ul>
                <?php
                    };
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
