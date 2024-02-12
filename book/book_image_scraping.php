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
$url = $_POST['url'];



    
?>

<script>
    let client = require('cheerio-httpcli');
    let url = "<?php echo $url ?>";
    let encodeURL = encodeURI(url);
    let param = {};

    client.fetch(encodeURL, param, function(err, $){
        if(err){console.log("Error:", err); return;}

        $('img[id="imgBlkFront"]').each(function(idx){
            let src = $(this).attr('data-a-dynamic-image');
            console.log(src);
        });
    })

    fetch('scraping_done.php', { // 第1引数に送り先
        method: 'POST', // メソッド指定
        headers: { 'Content-Type': 'application/json' }, // jsonを指定
        body: JSON.stringify(src) // json形式に変換して添付
    });

    window.alert('完了');
</script>
<?php require '../common/footer.php'; ?>