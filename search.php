<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
</head>

<link href="search.css" rel="stylesheet" type="text/css">

<body>

  <?php
  require_once('conn.php');

  $keyword = $_GET['content'];

  // Dont use empty() or you wont search "0"
  // content != ""
  if (!isset($keyword) || $keyword == "") {
    echo '<a href="index.php">回首頁</a><br>';
    die('查詢欄位不可空。');
  }
  ?>

  <a href="index.php">回首頁</a><br>

  <div>

    <?php
    try {
      $sth = $dbh->prepare("SELECT board.id, users.username, board.content, board.create_time, board.update_time FROM board INNER JOIN users ON board.user_id=users.id
                          WHERE content LIKE :content OR username LIKE :username
                          ORDER BY id DESC");
      $sth->execute(array(
        'content' => '%' . $keyword . '%',
        'username' => '%' . $keyword . '%'
      ));
      //print_r($sth->errorInfo());
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }

    $result = $sth->fetchAll();
    //print_r($result);
    //echo "Mom! I'm here!";

    if (!empty($result)) {
      //echo "Mom! I'm here!";
    ?>

      <table>
        <thead>
          <tr>
            <th>樓層</th>
            <th>姓名</th>
            <th>內容</th>
            <th>建立時間</th>
            <th>更新時間</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($result as $row) :
          ?>
            <tr>
              <td>
                <?= $i++ ?> 樓
              </td>
              <td>
                <?= $row['username'] ?>
              </td>
              <td class="content">
                <?= nl2br(htmlspecialchars($row['content'], ENT_QUOTES)) ?>
              </td>
              <td>
                <?= $row['create_time'] ?>
              </td>
              <td>
                <?= $row['update_time'] ?>
              </td>
            </tr>
          <?php
          endforeach;
          ?>
        </tbody>
      </table>

    <?php
    } else {
      echo "查無此資料。";
    }
    ?>

  </div>

</body>

</html>