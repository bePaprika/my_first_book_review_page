<?php
$sql = "CREATE TABLE IF NOT EXISTS Pre"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "urltoken char(255)," //URLtoken
. "mail char(128)," //メールアドレス
. "register_at DATETIME," //申込日時
. "flag INT" //フラグ
.");";
$stmt = $pdo->query($sql);
?>