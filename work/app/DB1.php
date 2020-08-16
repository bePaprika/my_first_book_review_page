<?php
require("../../sec_info.php");

$sql = "CREATE TABLE IF NOT EXISTS Data"
." ("
. "name char(128)," //ユーザー名
. "title TEXT,"   //書籍名
. "content TEXT," //この本に期待する内容
. "comment TEXT,"  //書籍へのコメント
. "date DATETIME," //書き込み日時
. "ongoing INT,"  //読書中ダミー
. "finished INT," //読了ダミー
. "frustrat INT" //挫折ダミー
.");";
$stmt = $pdo->query($sql);
?>