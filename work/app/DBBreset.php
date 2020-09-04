<?php
require("../../sec_info.php");

//Check
echo "投稿書籍情報一覧<br>";
$sql = 'SELECT * FROM Data';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['post_id'].' , ';
  echo $row['title'].' , ';
  echo $row['first'].' , ';
  echo $row['comment'].' , ';
  echo $row['name'].' , ';
  echo $row['post_at'].' , ';
  echo $row['fin'].' , ';
  echo $row['dis'].' , ';
  echo $row['public'].'<br>';
}
echo "<hr>";

//Delete
$sql = 'DROP TABLE Data';
$stmt = $pdo->query($sql);

//Create
$sql = "CREATE TABLE IF NOT EXISTS Data"
." ("
. "post_id INT AUTO_INCREMENT PRIMARY KEY," //投稿ID
. "title TEXT,"   //書籍名
. "first INT," //初投稿かどうか 1:初投稿
. "comment TEXT,"  //書籍へのコメント
. "id INT," //ユーザーid
. "name char(128)," //ユーザー名
. "post_at DATETIME," //書き込み日時
. "fin INT,"  //読了ダミー　 1:読了
. "dis INT,"  //挫折ダミー　 1:挫折
. "public INT" //公開ダミー  1:公開
.");";
$stmt = $pdo->query($sql);

echo "Dataを初期化しました<br>";
?>