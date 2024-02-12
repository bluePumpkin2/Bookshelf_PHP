<?php require '../common/header.php'; ?>
<?php
require_once(__DIR__.'/../common/func.php');
/*
if(!cken($_POST)){
    $encoding = mb_internal_encoding();
    $err = "Encoding Error! The expected encoding is" . $encoding;
    exit($err);
}
*/

try{
    $_POST = es($_POST);

    $user_name = $_POST['Uname'];
    $user_pass = $_POST['pass'];
    $user_pass2 = $_POST['pass2'];

    $dsn = 'mysql:dbname=mylibrary;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_select_sql = 'SELECT name FROM user';
    $stmt = $dbh -> prepare($user_select_sql);
    $stmt -> execute();
    $flag = true;
    while(true){
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        if($rec == false) break;
        if($rec['name'] == $user_name){
            $flag = false;
            break;
        }
    }
}
catch(Exception $e){
    print 'ただいま障害が発生しております。ご迷惑をお掛けして申し訳ございません。';
    exit();
}
?>

<?php if($user_name == ''):?>
    ユーザ名が入力されていません。<br>
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>

<?php elseif($user_pass == ''):?>
    パスワードが入力されていません。<br>
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>

<?php elseif($user_pass != $user_pass2):?>
    パスワードが一致しません。<br>
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>

<?php elseif($flag == false):?>
    そのユーザ名は既に使用されています。<br>
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>

<?php else:?>
    <?php $user_pass = hash('sha256', $user_pass); ?>
    ユーザ名 <?php echo $user_name ?> で登録します。よろしいですか？<br>
    <form method="post" action="user_add_done.php">
        <input type="hidden" name="name" value="<?php echo $user_name ?>">
        <input type="hidden" name="pass" value="<?php echo $user_pass ?>">
        <br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>

<?php endif ?>

<?php require '../common/footer.php'; ?>