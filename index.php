<?php
?>
<html>
<body>
<h1>SP1 start page</h1>
<a href="start.php">Log-in with IdP<br></a>
<form action="https://ap.local/sample/migr.php" method="post">
<input type="hidden" name="user_id" value="<?php echo $uid; ?>">
<input type="hidden" name="idp" value="<?php echo $idp; ?>">
<input type="hidden" name="sp" value="sp1">
<input type="submit" value="Migrate the IdP">
</body>
</html>
