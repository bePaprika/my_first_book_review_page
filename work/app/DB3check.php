<?php
require("../../sec_info.php");

//Check
echo "書籍一覧<br>";
echo "書籍番号/書籍名/著者/ISBN<br>";
$sql = 'SELECT * FROM Books';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['book_id'].' , ';
  echo $row['title'].' , ';
  echo $row['auther'].' , ';
  echo $row['ISBN'].'<br>';
}
echo "<hr>";
?>