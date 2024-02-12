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


<h1>My本棚</h1>
<button onclick="location.href='../mypage/top.php'">TOP画面へ</button>
<button onclick="location.href='book_add.php'">本を追加する</button><br>
<form method="post" action="">
    <label><input type="radio" name="sort" value="id" checked>登録順</label>
    <label><input type="radio" name="sort" value="rating">評価降順</label>
    <label><input type="radio" name="sort" value="date">日付降順</label>
    <input type="submit" value="再表示">
</form>
<br><br>


<?php

try{
    $sort = $_POST['sort'];

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_order_sql = "SELECT book_id, title, author, genre, rating, date, image FROM {$_SESSION['user_name']}_books ORDER BY book_id";
    $rating_order_sql = "SELECT book_id, title, author, genre, rating, date, image FROM {$_SESSION['user_name']}_books ORDER BY rating DESC";
    $date_order_sql = "SELECT book_id, title, author, genre, rating, date, image FROM {$_SESSION['user_name']}_books ORDER BY date DESC";

    if($sort == 'id'){
        $stmt = $dbh -> prepare($id_order_sql);
        $stmt -> execute();
    }
    if($sort == 'rating'){
        $stmt = $dbh -> prepare($rating_order_sql);
        $stmt -> execute();
    }
    if($sort == 'date'){
        $stmt = $dbh -> prepare($date_order_sql);
        $stmt -> execute();
    }

    $dbh = null;

    print '<form method="post" action="book_disp.php">';
    while(true){
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        if($rec == false){
            break;
        }
        print '<input type="radio" name="bookselect" value="'.$rec['book_id'].'" id="radio'.$rec['book_id'].'"><label for="radio'.$rec['book_id'].'">';
        print $rec['title']. '</label><br>';
        print '著：'. $rec['author'];
        print '　　';
        print $rec['genre']. '<br>';
        print $rec['date'];
        print '　　';
        print $rec['rating']. '点';
        print '　　';
        print '<input type="submit" value="詳細">';
        print '<br>';
        print '<img src="./'.$_SESSION['user_name'].'_book_images/'.$rec['image'].'">';
        print '<br><br><br>';
    }
    print '</form>';
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}

?>
<?php require '../common/footer.php'; ?>