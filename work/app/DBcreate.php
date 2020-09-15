<?php
require("../../sec_info.php");

//仮登録者データベース
$sql = "CREATE TABLE IF NOT EXISTS Pre"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "urltoken char(255)," //URLtoken
. "mead char(128)," //メールアドレス
. "register_at DATETIME," //申込日時
. "flag INT" //フラグ
.");";
$stmt = $pdo->query($sql);

//登録者データベース
$sql = "CREATE TABLE IF NOT EXISTS Accounts"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "name char(128)," //ユーザー名
. "mead char(128)," //メールアドレス
. "pass char(128)" //パスワード
.");";
$stmt = $pdo->query($sql);

//投稿データベース
$sql = "CREATE TABLE IF NOT EXISTS Data"
." ("
. "post_id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "title TEXT,"   //書籍名
. "auther TEXT,"   //著者名
. "first INT," //初投稿かどうか 1:初投稿
. "comment TEXT,"  //書籍へのコメント
. "deadline DATETIME," //いつまでに読むか
. "id INT," //ユーザーid
. "name char(128)," //ユーザー名
. "post_at DATETIME," //書き込み日時
. "fin INT,"  //読了ダミー　 1:読了
. "dis INT,"  //挫折ダミー　 1:挫折
. "public INT" //公開ダミー  1:公開
.");";
$stmt = $pdo->query($sql);
?>