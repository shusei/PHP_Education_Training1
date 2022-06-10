<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="board.css" rel="stylesheet" type="text/css">
  <title>留言板</title>
</head>

<body>
  <h1>我是留言板</h1>

  <div class="right">
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) :
    ?>

      <a href="loginPage.php">登入</a>
      <a href="signupPage.php">註冊</a>
      <!--  //echo 'session empty'; -->
    <?php
    else :
    ?>
      我：<?= $_SESSION['username'] ?>
      <a href='logout.php'>登出</a> 最後登入時間：<?= $_SESSION['login_time'] ?><br>
      <button class="styled" onclick="location.href='postPage.php'">我要留言</button>
      <!--  //echo 'session no empty'; -->
    <?php
    endif;
    ?>



    <form method="GET" action="search.php">
      我要搜尋 : <textarea rows="1" cols="27" name="content"></textarea>
      <input class="styled" type="submit" value="搜尋" />
    </form>
  </div>

  <div>
    <?php
    require_once('conn.php');

    try {
      $sth = $dbh->prepare("SELECT b.id, u.username, b.title, m.mood, b.content, b.create_time, b.update_time 
                            FROM board AS b
                            INNER JOIN users AS u ON u.id=b.user_id
                            INNER JOIN moods AS m ON m.id=b.mood
                            ORDER BY b.update_time DESC");
      $sth->execute();
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }

    $result = $sth->fetchAll();
    ?>

    <table>
      <!-- <caption>公子鈞的留言版</caption> -->
      <thead>
        <tr>
          <th>操作</th>
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
              <?php
              if (!empty($_SESSION['username']) && ($_SESSION['username'] == $row['username'])) :
              ?>
                <br><button class="styled" onclick="location.href='editPage.php?id=<?= $row['id'] ?>'">修改</button>
                <br><button class="styled" onclick="deleteFunction(<?= $row['id'] ?>)">刪除</button>
              <?php
              endif;
              ?>
            </td>
            <td>
              <?= $i++ ?> 樓
            </td>
            <td>
              <?= $row['username'] ?>
            </td>
            <td class="content">
              標題：
              <?= nl2br(htmlspecialchars($row['title'], ENT_QUOTES)) ?>
              <br>--<br>
              <?= nl2br(htmlspecialchars($row['content'], ENT_QUOTES)) ?>
              <br><br>--<br>心情：
              <?= $row['mood'] ?>
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
  </div>

  <?php
  // and now we're done; close it
  $sth = null;
  $dbh = null;
  ?>

  <script>
    function deleteFunction(id) {
      if (confirm("確定要刪除嗎？")) {
        window.location.href = "delete.php?id=" + id;
      } else {
        window.location.href = "index.php";
      }
    }
  </script>

</body>

</html>