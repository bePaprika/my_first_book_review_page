<?php
  $title = "メール認証 - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  createToken();
?>

<!-- ここからbody -->

<h1>仮登録画面</h1>
<p>登録用のメールアドレスを入力してください</p>

<!-- POST送信 -->
<form action="register2.php" method="post">
  <label>メールアドレス：<input type="text" name="mead" placeholder=""></label>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
  <button>送信</button>
</form>


<!-- TOPページへ戻る -->
<nav>
  <ul>
    <li><a href="register.php">仮登録画面へ戻る</a></li>
    <li><a href="index.php">掲示ページへ戻る</a></li>
  </ul>
</nav>

<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>