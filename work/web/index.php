<?php
  $title = "TOP - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php")
?>

<!-- ここからbody -->



<h1>タダ本</h1>
<p>本は読むと身になるので実質タダ!!<br>
実質タダじゃんと感じる本を共有しよう<br></p>


<nav>
  <ul>
    <li><a href="login.php">ログインする</a></li>
    <li><a href="register.php">アカウントを作る</a></li>
  </ul>
</nav>

<main>
<h1>新着レビュー</h1>
  <article>
    <h1>書籍名</h1>
    <p>hogehoge</p>
    <h1>本を読む目的</h1>
    <p>hogehoge</p>
    <h1>コメント</h1>
    <p>hogehoge</p>
    <footer>投稿日:<time>2020-08-12</time> by 投稿者</footer>
  <article>
</main>

<aside>
<h1>本ごとにレビューを見る</h1>
<h1>本を検索する</h1>

</aside>

<p><a href="#top">先頭へ戻る</a></p>
<!-- ここまでbody -->

<?php
  include("../app/_parts/_footer.php");
?>