<?php
require("../../sec_info.php");

$sql = 'DROP TABLE Pre';
$stmt = $pdo->query($sql);

$sql = 'DROP TABLE Accounts';
$stmt = $pdo->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Pre"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "urltoken char(255)," //URLtoken
. "mead char(128)," //メールアドレス
. "register_at DATETIME," //申込日時
. "flag INT" //フラグ
.");";
$stmt = $pdo->query($sql);

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
?>