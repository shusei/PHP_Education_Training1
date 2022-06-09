<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="search.css" rel="stylesheet" type="text/css">
  <title>Search</title>
</head>

<body>

  <?php
  require_once('conn.php');

  $keyword = $_GET['content'];

  // Dont use empty() or you wont search "0"
  // content != ""
  // https://www.php.net/manual/en/types.comparisons.php
  // isset() : 判斷一個變數是否已被宣告並且和NULL不同，和is_null()相反
  // empty() : 判斷一個變數是否為空
  if (!isset($keyword) || $keyword == "") :
  ?>
    <p>查詢欄位不可空。</p>
    <a href="index.php">回首頁</a><br>
  <?php
  else :
  ?>
    <a href="index.php">回首頁</a><br>

    <div>
      <?php
      try {
        $sth = $dbh->prepare("SELECT board.id, users.username, board.content, board.create_time, board.update_time 
                            FROM board INNER JOIN users ON board.user_id=users.id
                            WHERE content LIKE :content OR username LIKE :username
                            ORDER BY id DESC");
        $sth->execute(array(
          'content' => '%' . $keyword . '%',  // % 代表任意項任意值
          'username' => '%' . $keyword . '%'
        ));
        //print_r($sth->errorInfo());
      } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }

      $result = $sth->fetchAll();

      if (!empty($result)) :
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
      else :
      ?>
        <p>查無此資料。</p>
      <?php
      endif;
      ?>
    </div>
  <?php
  endif;
  ?>

</body>

</html>