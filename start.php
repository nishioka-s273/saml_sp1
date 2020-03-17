<?php
require_once('/var/www/simplesaml/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attr=$as->getAttributes();
$name=$as->getAuthData("saml:sp:NameID");
?>
<html>
<body>
<h1>This page is ServiceProvider start page.</h1>
<h2>NameID Format</h2>
<pre><?php print_r($name) ?></pre>
<h2>Attribute</h2>
<pre><?php print_r($attr) ?></pre>
<a href="logout.php">logout</a>
</body>
</html>
