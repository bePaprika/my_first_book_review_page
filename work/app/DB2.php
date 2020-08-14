$sql = "CREATE TABLE IF NOT EXISTS Account"
." ("
. "name char(16),"　//ユーザー名
. "mail TEXT," //メールアドレス
. "pass TEXT," //パスワード
. "intr TEXT"  //自己紹介
.");";
$stmt = $pdo->query($sql);