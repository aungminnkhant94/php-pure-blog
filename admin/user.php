<?php
session_start();
require "../config/config.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}
?>
  <?php
    include("header.php");
  ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Listings</h3>
              </div>
              <?php 
                if(!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }
                
                $numOfRecs = 3;
                $offset = ($pageno - 1) * $numOfRecs ;

                  $statement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
                  $statement->execute();
                  $rawresult = $statement->fetchAll(); 

                  $total_pages = ceil(count($rawresult)/$numOfRecs);

                  $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfRecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();

              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add_user.php" class="btn btn-success mb-3">Create New User</a>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th style="width: 200px">Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th style="width: 200px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($result) {
                        $i = 1;
                        foreach ($result as $value) {
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['name'] ?></td>
                      <td>
                          <?php echo substr($value['email'],0,150) ?>
                      </td>
                      <td>
                          <?php
                            if($value['role'] == 1) {
                                echo "Admin";
                            }else{
                                echo "User";
                            }
                          ?>
                      </td>
                      <td>
                        <a class="btn btn-warning"href="edit.php?id=<?php echo $value['id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $value['id'] ?>"
                           onclick="return confirm('Are you sure you want o delete this item')" 
                           class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                    <?php
                        $i++;
                        }
                      }
                    ?>
                  </tbody>
                </table>
                <!--pagination -->
                <ul class="pagination mt-2"style="float:right;">
                      <li class="page-item">
                        <a href="?pageno=1" class="page-link">First</a>
                      </li>
                      <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?> ">
                        <a href="<?php if($pageno <= 1){echo '#';} else {echo "?pageno=".($pageno - 1);} ?>" 
                           class="page-link">Previous</a>
                      </li>  
                      <li class="page-item">
                        <a href="" class="page-link"><?php echo $pageno; ?></a>
                      </li>
                      <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>">
                        <a href="<?php 
                                    if($pageno >= $total_pages) {echo '#';} else {echo"?pageno=".($pageno + 1);} 
                                 ?>" 
                           class="page-link">Next</a>
                      </li>
                      <li class="page-item">
                        <a href="?pageno=<?php echo $total_pages ?>" class="page-link">Last</a>
                      </li>                 
                </ul>
                <!-- /.pagination -->
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
      <?php
        include("footer.html");
      ?>
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
