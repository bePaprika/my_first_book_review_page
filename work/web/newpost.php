<?php
  $title = "新規投稿 - ";
  require("../app/function.php");
  include("../app/_parts/_header.php")
?>

<form action="result.php" method="post">
  書籍名　：<input type="text" name="booktitle" placeholder=""><br>
  この本に期待する内容：<textarea placeholder="ここにコメントを入力してください"></textarea>
  <button>送信</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
</form>


<?php
  include("../app/_parts/_footer.php");
?>