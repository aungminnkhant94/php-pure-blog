<?php
session_start();

require "config/config.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("Location: login.php");
}

$blogId = $_GET['id'];
$comment = $_POST['comment'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

$cmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
$cmt->execute();
$cmtresult = $cmt->fetchAll();

$authorId = $cmtresult[0]['author_id'];
$author = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
$author->execute();
$authorResult = $author->fetchAll();



if($_POST) {
    $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
    $result = $stmt->execute(
        array(':content'=>$comment,
              ':author_id' => $_SESSION['user_id'],
              ':post_id' => $blogId)
    );
    if($result) {
        header('Location:blogdetail.php?id='.$blogId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
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
        h1{
            text-align:center;
        }
        img {
            width: 600px;
            height: 1200px;
            margin: 20px auto;
            position : relative;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h1><?php echo $result[0]['title'] ?></h1>
                <img src="admin/images/<?php echo $result[0]['image']?>"class="card-img">
                <p class="h3 p-4">
                    <?php
                        echo $result[0]['content']
                    ?>
                </p>
            </div>
        </div>
       <ul class="list-group mb-2">
            <li class="list-group-item active">
                 <b>Comments </b>
            </li>                    
            <?php
                if($cmtresult) {
                    $i = 1;
                    foreach ($cmtresult as $comment){
            ?>
                    <li class="list-group-item">
                        <?php echo $comment['content'] ?>
                        <div class="small mt-2">
                                By <b><?php echo $authorResult[0]['name'] ?></b>,
                                <?php echo $comment['created_at'] ?>
                        </div>
                    </li>
            <?php
                $i++;
                    }
                }
            ?>
        </ul>

        <form action=""method="post">
                <input name="comment" type="text"class="form-control"placeholder="Press enter to post comment">
        </form>
    </div>
    

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>