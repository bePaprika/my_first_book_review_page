$sql = "CREATE TABLE IF NOT EXISTS Account"
." ("
. "name char(16),"
. "mail TEXT,"
. "pass TEXT,"
. "intr TEXT" 
.");";
$stmt = $pdo->query($sql);