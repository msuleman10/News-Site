<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  
                  <?php
                            include "config.php";

                            if (isset($_GET["cid"])) {
                                $cat = $_GET["cid"];
                            };
                            $limits = 3;
                            if (isset($_GET["page"])) {
                                $page = $_GET["page"];
                            }else {
                                $page = 1;
                            };
                            $offset = ($page - 1) * $limits;

                            $sql2 = "SELECT * FROM category WHERE category_id={$cat}";
                            
                            $result2 = mysqli_query($connect,$sql2);
                            $rows = mysqli_fetch_assoc($result2);
                            echo "<h2 class='page-heading'>{$rows['category_name']}</h2>";

                            $sql = "SELECT * FROM post 
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id 
                            WHERE category = {$cat}
                            ORDER BY post_id LIMIT {$offset},{$limits}";

                            $result = mysqli_query($connect,$sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_assoc($result)) { 
                        ?>
                        
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?pj=<?php echo $row["post_id"] ;?>"><img height="100%" src="admin/upload/<?php echo $row["post_img"] ;?>" /></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?pj=<?php echo $row["post_id"] ;?>'><?php echo $row["title"] ;?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row["category"] ;?>'><?php echo $row["category_name"] ;?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?apj=<?php echo $row["author"] ;?>'><?php echo $row["username"] ;?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row["post_date"] ;?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row["description"],0,150)."..."  ;?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?pj=<?php echo $row["post_id"] ;?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                };
                            }else {
                                echo "No Record found";
                            };

                           

                            if (mysqli_num_rows($result2) > 0) {
                                $total_records = $rows["post"];
                                $limit = 3;
                                $total_pages = ceil($total_records/$limit);
                                echo "<ul class='pagination admin-pagination'>";
                                if ($page > 1) {
                                    echo '<li><a href="index.php?cid='.$cat.'&page='.($page - 1).'">Prev</a></li>';
                                }
                                for ($i=1; $i <= $total_pages; $i++) { 
                                    if ($i == $page) {
                                        $active = "active";
                                    }else{
                                        $active = " ";
                                    };
                                    echo '<li class="'.$active.'"><a href="index.php?cid='.$cat.'&page='.$i.'">'.$i.'</a></li>';
                                }
                                if ($total_pages > $page) {
                                    echo '<li><a href="index.php?cid='.$cat.'&page='.($page + 1).'">Next</a></li>';
                                }
                                echo "</ul>";    
                            } 
                        ?>

                    <!-- <ul class='pagination'>
                        <li class="active"><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                    </ul> -->
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
