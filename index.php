<?php
session_start();

require "config/config.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style>
        body{
            background-color: rgb(253,243,205);
        }
    </style>
</head>
<body>
    <?php
      $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
      $statement->execute();
      $result = $statement->fetchAll(); 
    ?>
    <h1 style="text-align:center;">Blog Site</h1>
    <section class="container py-5">
        <div class="row g-5">
        <?php
              if($result) {
                $i = 1;
                foreach ($result as $value) {
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-widget">
                    <div class="card-header">
                        <div style="text-align:center;float:none" class="card-title">
                            <h4><?php echo $value['title'] ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <a href="blogdetail.php?id=<?php echo $value['id'] ?>">
                           <img src="admin/images/<?php echo $value['image']?>"class="card-img"style="height:200px;">
                        </a>
                    </div>

                </div>
            </div>
            <?php
                $i++;
                }
              }
            ?>
        </div>
    </section>
    <footer class="container">
        <!-- To the right -->
        <div class="border-top border-top-2 py-5 text-center text-muted ">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </div>
      </footer>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>