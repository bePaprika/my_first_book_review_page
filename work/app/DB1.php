$sql = "CREATE TABLE IF NOT EXISTS DATA"
." ("
. "name char(16),"//ユーザー名
. "title TEXT,"   //書籍名
. "content TEXT," //この本に期待する内容
. "comment,"      //書籍へのコメント
. "ongoing INT,"  //読書中ダミー
. "finished INT," //読了ダミー
. "frustrat INT," //挫折ダミー
. "good INT,"     //挫折ダミー
.");";
$stmt = $pdo->query($sql);