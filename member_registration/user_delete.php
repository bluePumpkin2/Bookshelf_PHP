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

<h1>退会する</h1>
ユーザ情報、My本棚、およびアップロードした画像を全て消去します。よろしいですか？<br>
<form method="post" action="user_delete_done.php">
    <input type="button" onclick="history.back()" value="いいえ">
    <input type="hidden" name="name" value="<?php echo $_SESSION['user_name'] ?>">
    <input type="submit" value="はい"> 
</form>

<?php require '../common/footer.php'; ?>