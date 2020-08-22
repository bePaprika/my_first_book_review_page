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
?>