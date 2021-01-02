<?php
session_start();
require "../config/config.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}
?>
  <?php
    include("header.html");
  ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listings</h3>
              </div>
              <?php
                $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                $statement->execute();
                $result = $statement->fetchAll(); 
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add.php" class="btn btn-success mb-3">Create New Blog</a>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th style="width: 200px">Title</th>
                      <th>Content</th>
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
                      <td><?php echo $value['title'] ?></td>
                      <td>
                          <?php echo substr($value['content'],0,150) ?>
                      </td>
                      <td>
                        <a class="btn btn-warning"href="edit.php?id=<?php echo $value['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="delete.php?id=<?php echo $value['id']; ?>">Delete</a>
                      </td>
                    </tr>
                    <?php
                        $i++;
                        }
                      }
                    ?>
                  </tbody>
                </table>
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
