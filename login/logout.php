<?php
session_set_cookie_params(0);
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()]) == true){
    setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
?>

<?php require '../common/header.php'; ?>

ログアウトしました。<br>
<br>
<a href="../login/login.html">ログイン画面へ</a>

<?php require '../common/footer.php'; ?>