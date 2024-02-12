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

<?php
try{
    if($_SESSION['book_id'] == false){
        print '本が選択されていません。<br>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        exit();
    }
    $book_id = $_SESSION['book_id'];

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM {$_SESSION['user_name']}_books WHERE book_id=?";
    $stmt = $dbh -> prepare($sql);
    $data[] = $book_id;
    $stmt -> execute($data);

    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    $title = $rec['title'];
    $author = $rec['author'];
    $genre = $rec['genre'];
    $date = $rec['date'];
    $rating = $rec['rating'];
    $report = $rec['report'];
    $image = $rec['image'];
    $url = $rec['url'];

    $dbh = null;
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

<h1>本を編集</h1><br>
<br>
<form method="post" action="branch.php" enctype="multipart/form-data">
    題名を入力してください。[150字以内]（※<font color="red">必須</font>）<br>
    <input type="text" name="title" style="width:200px" value="<?php echo $title ?>"><br><br>
    著者を入力してください。[30字以内]<br>
    <input type="text" name="author" style="width:200px" value="<?php echo $author ?>"><br><br>
    ジャンルを入力してください。[50字以内]<br>
    <input type="text" name="genre" style="width:200px" value="<?php echo $genre ?>"><br><br>
    本を読んだ日付を選択してください。<br>
    <input type="date" name="date" value="<?php echo $date ?>"><br><br>
    本の評価を100点満点で選択してください。<br>
    <input type="number" max="100" min="0" value="<?php echo $rating ?>" name="rating"><br><br>
    感想を入力してください。[5000字以内]<br>
    <textarea rows="10" cols="100" name="report"><?php echo $report ?></textarea><br><br>
    本の画像を選択してください。[jpg/jpeg, png, gifのみ]<br>
    <input type="file" name="image" accept=".jpg, .jpeg, .png, .gif, image/jpeg, image/png" style="width:400px">
    <input type="checkbox" id="del_check" onclick="this.form.delete.value=this.checked ? 1 : 0"><label for="del_check">現在の画像を削除する</label><br>
    <input type="hidden" name="delete" value="0">
    <input type="hidden" name="old_image" value="<?php echo $image ?>">
    現在の画像<br>
    <img src="./<?php echo $_SESSION['user_name'] ?>_book_images/<?php echo $image ?>"><br><br>
    Amazon等のURLを入力してください。<br>
    <input type="text" name="url" style="width:400px" value="<?php echo $url ?>"><br><br>
    <input type="submit" name="back_bookshelf" value="キャンセル">
    <input type="submit" name="to_book_edit_check" value="完了">
</form>

<?php require '../common/footer.php'; ?>