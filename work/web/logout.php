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
header('Location: login.php');
exit();
?>


<div><?php echo $error; ?></div>

<ul>
<li><a href="login.php">ログインページへ</a></li>
</ul>



<?php
  include("../app/_parts/_footer.php");
?>