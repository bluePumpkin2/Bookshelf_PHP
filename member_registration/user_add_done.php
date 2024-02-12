<?php require '../common/header.php'; ?>

<?php
try{
    require_once(__DIR__.'/../common/func.php');
    $_POST = es($_POST);
    
    $user_name = $_POST['name'];
    $user_pass = $_POST['pass'];

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $user_add_sql = 'INSERT INTO user(name, password) VALUES(?, ?)';
    $stmt = $dbh -> prepare($user_add_sql);
    $data[] = $user_name;
    $data[] = $user_pass;
    $stmt -> execute($data);
    
    $table_add_sql = "CREATE TABLE {$user_name}_books(
            book_id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(150) NOT NULL,
            author VARCHAR(30),
            genre VARCHAR(50),
            date DATE,
            report VARCHAR(5000),
            image VARCHAR(200),
            rating INT(3),
            url VARCHAR(500),
            PRIMARY KEY(book_id))";
    $stmt = $dbh -> prepare($table_add_sql);
    $stmt -> execute();

    $dbh = null;

    print $user_name;
    print '様：会員登録完了<br>';
    print 'ログインは<a href="../login/login.html">こちら</a>';
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

<?php require '../common/footer.php'; ?>