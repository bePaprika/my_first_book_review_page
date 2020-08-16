<?php
$sql = "CREATE TABLE IF NOT EXISTS Accounts"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "name char(128)," //ユーザー名
. "mail char(128)," //メールアドレス
. "pass char(128)," //パスワード
. "status INT," //1.本会員 2.仮会員
. "created_at DATETIME," //登録日
. "updated_at DATETIME," //更新日
. "intr TEXT"  //自己紹介
.");";
$stmt = $pdo->query($sql);

?>