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
. "pass char(128)," //パスワード
. "status INT," //1.本会員 2.仮会員
. "created_at DATETIME," //登録日
. "updated_at DATETIME," //更新日
. "intr TEXT"  //自己紹介
.");";
$stmt = $pdo->query($sql);

//投稿データベース
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