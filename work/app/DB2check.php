<?php
require("../../sec_info.php");

//Check
echo "投稿書籍情報一覧<br>";
echo "投稿番号/書籍名/著者/初回ダミー/コメント/締め切り/ユーザーid/ユーザーネーム/投稿時刻/読了/挫折/公開<br>";
$sql = 'SELECT * FROM Data';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['post_id'].' , ';
  echo $row['title'].' , ';
  echo $row['auther'].' , ';
  echo $row['first'].' , ';
  echo $row['comment'].' , ';
  echo $row['deadline'].' , ';
  echo $row['id'].' , ';
  echo $row['name'].' , ';
  echo $row['post_at'].' , ';
  echo $row['fin'].' , ';
  echo $row['dis'].' , ';
  echo $row['public'].'<br>';
}
echo "<hr>";
?>