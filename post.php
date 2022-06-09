<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新增留言</title>
</head>

<body>

  <?php
  require_once('conn.php');


  session_start();

  if (!isset($_SESSION['user_id'])) :
  ?>
    <p>請先登入帳號</p>
    <a href="index.php">回首頁</a>
  <?php
  else :
    $user_id = $_SESSION['user_id'];
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
  endif;
  ?>

</body>

</html>