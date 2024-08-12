<?php include "header.php"; 

    // include "config.php";
    // // session_start();

    // if ($_SESSION["user_role"] == 0) {
    //     header("location: {$host}/admin/post.php");
    // } ;
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                <?php
                    include "config.php";
                    $limits = 3;
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                    }else {
                        $page = 1;
                    };
                    $offset = ($page - 1) * $limits;

                    if ($_SESSION["user_role"] == 1) {
                        $sql = "SELECT * FROM post 
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id 
                        ORDER BY post_id LIMIT {$offset},{$limits}";

                    }elseif ($_SESSION["user_role"] == 0) {
                        $sql = "SELECT * FROM post 
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id 
                        WHERE post.author = {$_SESSION['user_id']}
                        ORDER BY post_id LIMIT {$offset},{$limits}";

                    } ;

                    $result = mysqli_query($connect,$sql);
                    if (mysqli_num_rows($result)) {
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                            while ($row = mysqli_fetch_assoc($result)) { 
                        ?>
                          <tr>
                              <td class='id'><?php echo $row["post_id"]; ?></td>
                              <td><?php echo $row["title"]; ?></td>
                              <td><?php echo $row["category_name"]; ?></td>
                              <td><?php echo $row["post_date"]; ?></td>
                              <td><?php echo $row["username"]; ?></td>
                              <td class='edit'><a href='update-post.php?ppage=<?php echo $row["post_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?ppage=<?php echo $row["post_id"]; ?>&pcat=<?php echo $row["category"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          }
                          ?>          
                      </tbody>
                  </table>
                  <?php
                  }

                  $sql2 = "SELECT * FROM post";
                  $result2 = mysqli_query($connect,$sql2);
                  if (mysqli_num_rows($result2) > 0) {
                      $total_records = mysqli_num_rows($result2);
                      $limit = 3;
                      $total_pages = ceil($total_records/$limit);
                      echo "<ul class='pagination admin-pagination'>";
                      if ($page > 1) {
                          echo '<li><a href="post.php?page='.($page - 1).'">Prev</a></li>';
                      }
                      for ($i=1; $i <= $total_pages; $i++) { 
                          if ($i == $page) {
                              $active = "active";
                          }else{
                              $active = " ";
                          };
                          echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                      }
                      if ($total_pages > $page) {
                          echo '<li><a href="post.php?page='.($page + 1).'">Next</a></li>';
                      }
                      echo "</ul>";    
                  } 
                  ?>
                  
                    <!-- <li class="active"><a>1</a></li> -->
                  
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
