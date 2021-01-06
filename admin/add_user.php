<?php
session_start();
require "../config/config.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($_POST['role'])) {
        $role = 0;
    }else {
        $role = 1;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        echo "<script>
            alert('This Email is already taken')
        </script>";
    }else{
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (:name,:email,:password,:role)");
        $result = $stmt->execute(
            array(
                ':name' => $name,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role
            )
        );
        if($result) {
            echo "<script>
                alert('Successfully Registered , You can now Log In');
                window.location.href = 'user.php';
              </script>";
        }
    }
}
?>

<!-- header -->
  <?php
    include("header.php");
  ?>
<!-- end header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
              <form action="add_user.php"method="post"e>
                  <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text"class="form-control"name="name"required>
                  </div>
                  <div class="form-group">
                    <label for="content">Email</label>
                    <input type="email"class="form-control"name="email"required>
                  </div>
                  <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password"name="password"class="form-control"name="password",placeholder="Password">
                  </div>
                  <div class="form-group">
                      <label for="role">Admin</label>
                      <input type="checkbox"name="role"value="1">
                  </div>
                  <div class="form-group">
                    <input type="submit"value="SUBMIT"class="btn btn-success">
                    <a href="user.php"class="btn btn-dark">Back</a>
                  </div>
              </form>
              </div>
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
