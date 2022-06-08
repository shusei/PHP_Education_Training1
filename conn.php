
<?php
date_default_timezone_set("Asia/Taipei");

try {
  // DSN = Data Source Name
  $dsn = 'mysql:dbname=project_board;host=localhost';
  $user = 'webAdmin';
  $password = 'Aabbcc123';

  // DBH = Datebase Handle
  $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
