<?php require '../common/footer.php'; ?>

<?php
require_once(__DIR__.'/../common/func.php');
$_POST = es($_POST);
try{
    $user_name = $_POST['name'];
    $user_pass = $_POST['pass'];

    $user_pass = hash('sha256', $user_pass);

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT name FROM user WHERE name=? AND password=?';
    $stmt = $dbh -> prepare($sql);
    $data[] = $user_name;
    $data[] = $user_pass;
    $stmt -> execute($data);

    $dbh = null;

    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

    if($rec == false){
        print 'ユーザ名またはパスワードが間違っています。<br>';
        print '<a href="login.html">戻る</a>';
    }else{
        session_set_cookie_params(0);
        session_start();
        $_SESSION['login'] = 1;
        $_SESSION['user_name'] = $rec['name'];
        $_SESSION['sort'] = "id";

        header('Location: ../mypage/top.php');
        exit();
    }
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

<?php require '../common/footer.php'; ?>