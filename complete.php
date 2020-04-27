<?php
require_once('/var/www/simplesaml/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attr=$as->getAttributes();
$name=$as->getAuthData("saml:sp:NameID");

include('db_login.php');

$connection = mysqli_connect($db_host, $db_username, $db_password);
if(!$connection){
	die("[error1] Could not connect to the database: <br />".mysqli_error());
}

$db_select = mysqli_select_db($connection, $db_database);
if(!$db_select){
	die("[error2] Could not select the database: <br />".mysqli_error());
}

$uid_idp = $attr['uid'][0].'_sp1';
$idp = $attr['idp'][0];

// APに保存していた引継IDをクッキーから取得
if (isset($_COOKIE["mig_id"])){
        $mig_id = $_COOKIE["mig_id"];
}
$mig_id = $_POST["mig_id_sp"];

// 該当の引継IDを持つユーザを検索する
// Search the user corresponding to the migration ID received from the AP
$query1 = "SELECT uid FROM users WHERE mig_id = '$mig_id'";
$result1 = mysqli_query($connection, $query1);
if(!$query1) {
	die ("[error3] Could not query the database: <br />".mysqli_error());
}
else {
	$result_row1 = mysqli_fetch_row($result1);
	$uid = $result_row1[0];
	// 該当の引継IDを持つユーザが存在しない場合
	// if no user existing
	if ($uid == NULL) {
		echo "No user exist";
	}
	else {
		// 該当ユーザのIdPのIDを更新する
		// update the user ID from IdP (idp_uid)
		$query2 = "UPDATE users SET idp_uid = '$uid_idp' WHERE uid = '$uid'";
		$result2 = mysqli_query($connection, $query2);
		if (!$query2) {
			die ("[error4] Could not query the database: <br />".mysqli_error());
		}
		else {
			echo "IdP Migration Has Completed!<br>";
		}
	}
}

?>
<html>
<body>
<a href="index.php">Return to Home</a>
</body>
</html>
