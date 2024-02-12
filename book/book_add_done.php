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
require_once(__DIR__.'/../common/func.php');
$_POST = es($_POST);

$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$date = $_POST['date'];
$rating = intval($_POST['rating']);
$report = $_POST['report'];
$image = $_POST['image'];
$url = $_POST['url'];

try{
    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO {$_SESSION['user_name']}_books (title, author, genre, date, report, image, rating, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh -> prepare($sql);
    $data[] = $title;
    $data[] = $author;
    $data[] = $genre;
    $data[] = $date;
    $data[] = $report;
    $data[] = $image;
    $data[] = $rating;
    $data[] = $url;
    $stmt -> execute($data);

    $dbh = null;
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}

print 'タイトル：' .$title. '　著：' .$author;
print 'を追加しました。<br>';
?>

<form method="post" action="bookshelf.php">
    <input type="hidden" name="sort" value="id">
    <input type="submit" value="My本棚へ">
</form>

<?php require '../common/footer.php'; ?>