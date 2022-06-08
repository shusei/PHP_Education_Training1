<?php
require_once('conn.php');
require_once('function.php');

session_start();
$id = $_POST['id'];
$content = $_POST['content'];
//echo $id . " - " . $content;


// update time
$update_time = date("Y-m-d h:i:s");


checkName($id);

try {
    $sth = $dbh->prepare("UPDATE board SET content = :content, update_time = :update_time WHERE id = :id");
    $sth->execute(array(
        'content' => $content,
        'update_time' => $update_time,
        'id' => $id
    ));
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

header("Location: index.php");
