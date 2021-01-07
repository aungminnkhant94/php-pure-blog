<?php
session_start();
require "../config/config.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if ($_POST) {
  if (empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])) {
    if (empty($_POST['title'])) {
      $titleError = "Title cannot be null";
    }
    if (empty($_POST['content'])) {
      $contentError = "Content cannot be null";
    }
    if (empty($_FILES['image'])) {
      $imageError = "Image cannot be null";
    }
  }
}else{
  $file = 'images/'.($_FILES['image']['name']); 
  $imageType = pathinfo($file,PATHINFO_EXTENSION);
  
  if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
    echo "<script>
      alert('Image can't insert')
    </script>";
  }else{
    $title = $_POST['title']; 
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],$file);

    $stmt = $pdo->prepare("INSERT INTO posts (title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
    $result = $stmt->execute(
      array(':title'=>$title,
            ':content' => $content,
            ':author_id' => $_SESSION['user_id'],
            ':image' => $image)
    );
    if($result) {
      echo "<script>
          alert('Successfully Updated');window.location.href ='index.php';
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
              <form action="add.php"method="post"enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <p style="color:red"><?php echo empty($titleError) ? '' : '*'.$titleError; ?></p>
                    <input type="text"class="form-control"name="title">
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                    <p style="color:red"><?php echo empty($contentError) ? '' : '*'.$contentError; ?></p>
                    <textarea name="content"class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <p style="color:red"><?php echo empty($imageError) ? '' : '*'.$imageError; ?></p>
                    <input type="file"name="image">
                  </div>
                  <div class="form-group">
                    <input type="submit"value="SUBMIT"class="btn btn-success">
                    <a href="index.php"class="btn btn-dark">Back</a>
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
