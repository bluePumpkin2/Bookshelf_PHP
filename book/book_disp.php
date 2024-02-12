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
if(isset($_POST['bookselect']) == false){
    print '本が選択されていません。<br>';
    print '<form method="post" action="bookshelf.php">';
    print '<input type="hidden" name="sort" value="id">';
    print '<input type="submit" value="戻る">';
    print '</form>';
    exit();
}

try{
    require_once(__DIR__.'/../common/func.php');
    $_POST = es($_POST);

    $book_id = $_POST['bookselect'];
    $_SESSION['book_id'] = $book_id;

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

<img src="./<?php echo $_SESSION['user_name'] ?>_book_images/<?php echo $image ?>"><br><br>
タイトル：<?php echo $title ?><br>
著者：<?php echo $author ?><br>
読み終えた日：<?php echo $date ?><br>
評価：<?php echo $rating ?>点<br>
感想：<br><?php echo $report ?><br><br>
<?php if($url): ?>
    <a href="<?php echo $url ?>" target="_blank" rel="noopener noreferrer">ECサイトへ</a><br><br>
<?php endif ?>

<form method="post" action="bookshelf.php">
    <input type="hidden" name="sort" value="id">
    <input type="submit" value="戻る">
</form>
<button onclick="location.href='book_edit.php'">修正</button>
<button onclick="location.href='book_delete.php'">削除</button>

<form method="post" action="book_image_scraping.php">
    <input type="hidden" name="url" value="<?php echo $url ?>">
    <input type="submit" value="URLから画像を探す">
</form>
<?php require '../common/footer.php'; ?>