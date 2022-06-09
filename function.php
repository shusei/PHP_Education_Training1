<?php
function checkUserId($id)
{
    require_once('conn.php');

    try {
        global $dbh;
        $sth = $dbh->prepare("SELECT * FROM board WHERE id = :id");
        $sth->execute(array(
            'id' => $id
        ));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    // session是否已經啟動
    // === : equal and same type
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 判斷是不是session使用者修改自己資料
    if ($result['user_id'] != $_SESSION['user_id']) {
        return false;
    } else {
        return true;
    }
}
