<?php

?>
<html>
<body>
<h1>SP1 スタートページ</h1>
<a href="start.php">IdPでログイン<br></a>
<form action="http://ap.local/sample/migr.php" method="post">
<input type="hidden" name="user_id" value="<?php echo $uid; ?>">
<input type="hidden" name="idp" value="<?php echo $idp; ?>">
<input type="hidden" name="sp" value="sp1">
<input type="submit" value="IdPのお引越しを行う">
</body>
</html>
