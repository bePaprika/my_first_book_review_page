<?php
  $title = "ログアウト - ";
  require("../app/function.php");
  require("../../sec_info.php");
  include("../app/_parts/_header.php");

  $errors = array();
?>

<?php
session_destroy();

$_SESSION['message'] = "ログアウトしました。";
header("Location: https://tb-220261.tech-base.net/TADABON/work/web/index.php");
exit();
?>


<div><?php echo $error; ?></div>

<ul>
<li><a href="login.php">ログインページへ</a></li>
</ul>



<?php
  include("../app/_parts/_footer.php");
?>