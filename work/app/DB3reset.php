<?php
require("../../sec_info.php");

//Check
echo "書籍一覧<br>";
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

//Delete
$sql = 'DROP TABLE Books';
$stmt = $pdo->query($sql);

//Create
$sql = "CREATE TABLE IF NOT EXISTS Books"
." ("
. "book_id INT AUTO_INCREMENT PRIMARY KEY," //投稿ID
. "title TEXT,"   //書籍名
. "auther TEXT,"   //著者名
. "ISBN TEXT"   //ISBN
.");";
$stmt = $pdo->query($sql);

echo "Booksを初期化しました<br>";
?>