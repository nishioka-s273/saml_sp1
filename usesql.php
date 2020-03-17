<html>
<head>
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<title>PHPのテスト</title>
</head>
<body>
<?php
	// サーバ接続
	$con = mysql_connect("localhost", "root", "Pw_centos_sp1") or die("接続失敗");

	// データベースを選択
	mysql_select_db('example', $con) or dir("DBがありません");

	// 文字化け防止
	$strsql = "SET CHARACTER SET UTF8";
	mysql_query($strsql, $con);

	$strsql = "select * from friend";

	// SQL実行
	$res = mysql_query($strsql, $con);
	print "照会件数 = ".mysql_num_rows($res)."<br>";

	// 展開
	while ($item = mysql_fetch_array($res)) {
		print $item[0]." ".$item[1]."<br>";
	}

	// 接続をクローズ
	mysql_close($con);

?>
</body>
</html>
