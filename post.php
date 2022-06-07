<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  require_once('conn.php');

  /*
if (empty($_POST['username'])) {
  die('Please input your name.');   
}  
*/

  session_start();
  $user_id = $_SESSION['user_id'];
  //$username = $_SESSION['username'];
  $content = $_POST['content'];

  // create time
  date_default_timezone_set("Asia/Taipei");
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
  ?>
</body>

</html>