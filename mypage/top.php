<?php
session_set_cookie_params(0);
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login']) == false){
    print 'ログインされていません。<br>';
    print '<a href="../login/login.html">ログイン画面へ</a>';
    exit();
}else{
    print $_SESSION['user_name'];
    print 'さんログイン中<br>';
    print '<br>';
}
?>

<?php require '../common/header.php'; ?>

<h1>トップ画面</h1>
<form method="post" action="../book/bookshelf.php">
    <input type="hidden" name="sort" value="id">
    <input type="submit" value="My本棚へ">
</form>
<button onclick="location.href='../login/logout.php'">ログアウト</button>
<button onclick="location.href='../member_registration/user_delete.php'">退会する</button>

<?php require '../common/footer.php'; ?>