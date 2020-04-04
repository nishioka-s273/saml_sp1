<?php
require_once('/var/www/simplesaml/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attr=$as->getAttributes();
$name=$as->getAuthData("saml:sp:NameID");

include('db_login.php');
$connection = mysqli_connect($db_host, $db_username, $db_password);
if(!$connection){
  die ("[error1] Could not connect to the database: <br />". mysqli_error());
}

$db_select = mysqli_select_db($connection, $db_database);
if(!$db_select){
  die ("[error2] Could not select the database: <br />". mysqli_error());
}
?>
<html>
<body>
<h1>ServiceProvider_1</h1>
<h2>ログインが完了しました</h2>
<pre><?php
    $idp_uid = $attr['uid'][0].'_sp1';
    $idp = $attr['idp'][0];
    print('IdPのユーザID : '.htmlspecialchars($idp_uid)."<br />");

    // ログイン元IdPのユーザIDに対応するアカウントが存在するか確認する 
    $query1 = "SELECT uid FROM users WHERE ".$idp."_uid = '$idp_uid'";
    $result1 = mysqli_query($connection, $query1);
    $result_row1 = mysqli_fetch_row($result1);
    $uid = $result_row1[0];
    if(!$result1){
    	die("[error3] Could not query the database: <br />".mysqli_error());
    }
    // 該当ユーザが存在しない場合，新たに作成する
    else if($uid == NULL) {
	// 最新のユーザに対応するユーザIDの番号を取得する
	$query2 = "SELECT uid_num FROM users ORDER BY uid DESC LIMIT 1";
    	$result2 = mysqli_query($connection, $query2);
	$result_row2 = mysqli_fetch_row($result2);
	$latest_num = $result_row2[0]; // 最新ユーザの番号
	if(!$result2){
		die("[error4] Could not query the database: <br />".mysqli_error());
	}
	else {
		// 今回作成するユーザの番号
		$u_num = $latest_num + 1;
		$uid = 'sp1_user'.$u_num;
		// 新たにユーザ登録をする
		$query3 = "INSERT INTO users VALUES ('$uid', '', '', 0, '$u_num', '')";
		$result3 = mysqli_query($connection, $query3);
		if(!$result3){
			die ("[error5] Could not query the database: <br />".mysqli_error());
		}
		else {
			// IdPのユーザIDを設定する
			$query4 = "UPDATE users SET ".$idp."_uid = '$idp_uid' WHERE uid = '$uid'";
			$result4 = mysqli_query($connection, $query4);
			if(!$result4){
				die ("[error6] Could not query the database: <br />".mysqli_error());
			}
			else {
				echo "ユーザ登録が完了しました";
			}
		}
	}
    }
    else {
	// 既存ユーザはログインを行うのみ
	echo "ログインが完了しました！";
    }
?></pre>
<form action="http://ap.local/sample/" method="post">
<?php
    // 引継IDをすでに発行済み（APに送信済み）か確認する
    $query5 = "SELECT mig_id FROM users WHERE uid = '$uid'";
    $result5 = mysqli_query($connection, $query5);
    if (!$result5) {
    	die ("[error7] Could not query the database: <br />".mysqli_error());
    }
    else {
	$result_row5 = mysqli_fetch_row($result5);
	$mig_id = $result_row5[0];
	if ($mig_id == NULL) {
		// 引継IDが未発行の場合新たに発行する
		$mig_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8); //ランダム文字列生成(引継ID)
		// 発行した引継IDを登録する
		$query6 = "UPDATE users SET mig_id = '$mig_id' WHERE uid = '$uid'";
		$result6 = mysql_query($connection, $query6);
		if (!$result6) {
        		die ("[error8] Could not query the database: <br />".mysqli_error());;
    		}
	}
	}
?>
<input type="hidden" name="mig_id" value="<?php echo $mig_id; ?>">
<input type="hidden" name="sp" value="sp1">
<input type="submit" value="お引越しサービスに登録する">
</form>
<form action="http://ap.local/sample/migr.php" method="post">
<input type="hidden" name="sp" value="sp1">
<input type="submit" value="IdPのお引越しを行う">
</form>
<a href="logout.php">ログアウト</a>
</body>
</html>
