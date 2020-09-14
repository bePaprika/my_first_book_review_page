<?php
  $title = "メール認証 - ";
  require("../../sec_info.php");
  require("../app/function.php");
  include("../app/_parts/_header.php");

  createToken();
?>

<!-- ここからbody -->

<h2>仮登録</h2>

<div class="box_form">
  <p>登録用のメールアドレスを入力してください</p>

  <!-- POST送信 -->
  <form action="register2.php" method="post">
    <p><label>メールアドレス：<input type="text" name="mead" placeholder=""></label><p>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
    <input type="submit" class="submit" value="送信">
  </form>
</div>


<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>