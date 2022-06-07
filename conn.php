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
  try {
    // DSN = Data Source Name
    $dsn = 'mysql:dbname=project_board;host=localhost';
    $user = 'webAdmin';
    $password = 'Aabbcc123';

    // DBH = Datebase Handle
    $dbh = new PDO($dsn, $user, $password);

    /*
  if (!empty($conn->connect_error)) {
    die('database connect failed:' . $conn->connect_error);
  }
  */
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
  ?>
</body>

</html>