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
    require_once(__DIR__.'/../common/func.php');
    $_POST = es($_POST);

    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $date = $_POST['date'];
    $rating = $_POST['rating'];
    $report = $_POST['report'];
    $image = $_POST['image'];
    $old_image = $_POST['old_image'];
    $url = $_POST['url'];

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE {$_SESSION['user_name']}_books SET title=?, author=?, genre=?, date=?, report=?, image=?, rating=?, url=? WHERE book_id=?";
    $stmt = $dbh -> prepare($sql);
    $data[] = $title;
    $data[] = $author;
    $data[] = $genre;
    $data[] = $date;
    $data[] = $report;
    $data[] = $image;
    $data[] = $rating;
    $data[] = $url;
    $data[] = $_SESSION['book_id'];
    $stmt -> execute($data);

    $dbh = null;

    if($old_image != $image){
        if($old_image != 'noimage.png'){
            unlink("./{$_SESSION['user_name']}_book_images/{$old_image}");
        }
    }
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。'. $e;
    exit();
}
?>

正常に変更されました。<br>
<form method="post" action="bookshelf.php">
    <input type="hidden" name="sort" value="id">
    <input type="submit" value="My本棚へ">
</form>
<?php require '../common/footer.php'; ?>