<?php
require_once('/var/www/simplesaml/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();
$as->logout('http://sp1.local/sample/index.php');
?>
