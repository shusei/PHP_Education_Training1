<?php
require_once('conn.php');

session_start();
$user_id = $_SESSION['user_id'];
//$username = $_SESSION['username'];
$content = $_POST['content'];

// create time
$create_time = date("Y-m-d h:i:s");

try {
  $sth = $dbh->prepare("INSERT INTO board(user_id, content, create_time)
  VALUES(:user_id, :content, :create_time)");
  $sth->execute(array(
    'user_id' => $user_id,
    'content' => $content,
    'create_time' => $create_time
  ));
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

header("Location: index.php");
