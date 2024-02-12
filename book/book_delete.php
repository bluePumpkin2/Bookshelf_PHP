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

    $sql = "SELECT title, author, image FROM {$_SESSION['user_name']}_books WHERE book_id=?";
    $stmt = $dbh -> prepare($sql);
    $data[] = $book_id;
    $stmt -> execute($data);

    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    $title = $rec['title'];
    $author = $rec['author'];
    $image = $rec['image'];

    $dbh = null;
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

<h1>本の削除</h1>
この本を削除してよろしいですか？<br><br>
タイトル：<?php echo $title ?><br>
著者：<?php echo $author ?><br>
<img src="./<?php echo $_SESSION['user_name'] ?>_book_images/<?php echo $image ?>"><br><br>

<form method="post" action="branch.php">
    <input type="hidden" name="sort" value="id">
    <input type="submit" name="back_bookshelf" value="キャンセル">
    <input type="hidden" name="book_id" value="<?php echo $book_id ?>">
    <input type="hidden" name="image" value="<?php echo $image ?>">
    <input type="submit" name="to_book_delete_done" value="OK">
</form>

<?php require '../common/footer.php'; ?>