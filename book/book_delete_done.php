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
    $book_id = $_POST['book_id'];
    $image = $_POST['image'];

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM {$_SESSION['user_name']}_books WHERE book_id=?";
    $stmt = $dbh -> prepare($sql);
    $data[] = $book_id;
    $stmt -> execute($data);

    $dbh = null;

    if($image != 'noimage.png'){
        unlink("./{$_SESSION['user_name']}_book_images/{$image}");
    }
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

正常に削除されました。<br>
<form method="post" action="bookshelf.php">
    <input type="hidden" name="sort" value="id">
    <input type="submit" value="My本棚へ">
</form>

<?php require '../common/footer.php'; ?>