<?php require '../common/header.php'; ?>

<h1>会員登録</h1>
<form method="post" action="user_add_check.php">
    ユーザ名を入力してください。<br>
    <input type="text" name="Uname" style="width:200px"><br>
    パスワードを入力してください。<br>
    <input type="password" name="pass" style="width:200px"><br>
    パスワードをもう一度入力してください。<br>
    <input type="password" name="pass2" style="width:200px"><br>
    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="完了">
</form>

<?php require '../common/footer.php'; ?>