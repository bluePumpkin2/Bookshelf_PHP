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

<h1>本を追加</h1>
<form method="post" action="branch.php" enctype="multipart/form-data">
    題名を入力してください。[150字以内]（※<font color="red">必須</font>）<br>
    <input type="text" name="title" style="width:200px"><br><br>
    著者を入力してください。[30字以内]<br>
    <input type="text" name="author" style="width:200px"><br><br>
    ジャンルを入力してください。[50字以内]<br>
    <input type="text" name="genre" style="width:200px"><br><br>
    本を読んだ日付を選択してください。<br>
    <input type="date" name="date"><br><br>
    本の評価を100点満点で選択してください。<br>
    <input type="number" max="100" min="0" value="50" name="rating"><br><br>
    感想を入力してください。[5000字以内]<br>
    <textarea rows="10" cols="100" name="report"></textarea><br><br>
    本の画像を選択してください。[jpg/jpeg, png, gifのみ]<br>
    <input type="file" name="image" accept=".jpg, .jpeg, .png, .gif, image/jpeg, image/png" style="width:400px"><br><br>
    Amazon等のURLを入力してください。<br>
    <input type="text" name="url" style="width:400px"><br><br>
    <input type="hidden" name="sort" value="id">
    <input type="submit" name="back_bookshelf" value="戻る">
    <input type="submit" name="to_book_add_check"value="完了">
</form>

<?php require '../common/footer.php'; ?>