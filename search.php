<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <!-- <h2 class="page-heading">Search : Search Term</h2> -->
                    <?php
                    include "config.php";

                    if (isset($_GET["search"])) {
                        $search_term = $_GET["search"];
                    };
                    $limits = 3;
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                    } else {
                        $page = 1;
                    };
                    $offset = ($page - 1) * $limits;
                    echo "<h2 class='page-heading'>Search :{$search_term}</h2>";
                    $sql = "SELECT * FROM post 
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id 
                        WHERE title LIKE '%{$search_term}%'
                        ORDER BY post_id LIMIT {$offset},{$limits}";

                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?pj=<?php echo $row["post_id"]; ?>"><img height="100%" src="admin/upload/<?php echo $row["post_img"]; ?>" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?pj=<?php echo $row["post_id"]; ?>'><?php echo $row["title"]; ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cid=<?php echo $row["category"]; ?>'><?php echo $row["category_name"]; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?apj=<?php echo $row["author"]; ?>'><?php echo $row["username"]; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row["post_date"]; ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row["description"], 0, 150) . "..."; ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?pj=<?php echo $row["post_id"]; ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        };
                    } else {
                        echo "No Record found";
                    };

                    $sql2 = "SELECT * FROM post 
                            WHERE post.title LIKE '%{$search_term}%'";
                    $result2 = mysqli_query($connect, $sql2);
                    $rows = mysqli_fetch_assoc($result2);

                    if (mysqli_num_rows($result2) > 0) {
                        $total_records = mysqli_num_rows($result2);
                        $limit = 3;
                        $total_pages = ceil($total_records / $limit);
                        echo "<ul class='pagination admin-pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="index.php?search=' . $search_term . '&page=' . ($page - 1) . '">Prev</a></li>';
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                $active = "active";
                            } else {
                                $active = " ";
                            };
                            echo '<li class="' . $active . '"><a href="index.php?page=' . $i . '&search=' . $search_term . '">' . $i . '</a></li>';
                        }
                        if ($total_pages > $page) {
                            echo '<li><a href="index.php?page=' . ($page + 1) . '&search=' . $search_term . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>