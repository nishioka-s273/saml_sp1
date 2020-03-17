<?php
require_once('/var/www/simplesaml/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attr=$as->getAttributes();
$name=$as->getAuthData("saml:sp:NameID");

include('db_login.php');

$connection = mysql_connect($db_host, $db_username, $db_password);
if(!$connection){
	die("Could not connect to the database: <br />".mysql_error());
}

$db_select = mysql_select_db($db_database);
if(!$db_select){
	die("Could not select the database: <br />".mysql_error());
}

$uid_idp = $attr['uid'][0].'_sp1';
echo $idp_uid."<br />";
$idp = $attr['idp'][0];

// APに保存していた引継IDをクッキーから取得
if (isset($_COOKIE["mig_id"])){
        $mig_id = $_COOKIE["mig_id"];
	echo $mig_id."<br />";
}

// 該当の引継IDを持つユーザを検索する
$query1 = "SELECT uid FROM users WHERE mig_id = '$mig_id'";
$result1 = mysql_query($query1);
if(!$query1) {
	die ("Could not query the database: <br />".mysql_error());
}
else {
	$result_row1 = mysql_fetch_row($result1);
	$uid = $result_row1[0];
	// 該当の引継IDを持つユーザが存在しない場合
	if ($uid == NULL) {
		echo "ユーザが存在しません";
	}
	else {
		// 該当ユーザのIdPのIDを更新する
		$query2 = "UPDATE users SET ".$idp."_uid = '$uid_idp' WHERE uid = '$uid'";
		$result2 = mysql_query($query2);
		if (!$query2) {
			die ("Could not query the database: <br />".mysql_error());
		}
		else {
			echo "IdPのお引越しが完了しました！";
		}
	}
}

?>
<html>
<body>
<a href="index.php">ホームへ</a>
</body>
</html>
