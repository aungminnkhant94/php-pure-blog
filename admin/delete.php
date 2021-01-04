<?php
require "../config/config.php";
$stmt = $pdo->prepare("DELETE from posts WHERE id=".$_GET['id']);
$stmt->execute();

header("Location:index.php");
?>