<?php

$mig_id = $_POST["mig_id_sp"];
// SPの引継IDをクッキーに保存する(暫定として1時間)
setcookie("mig_id", $mig_id, time() + 60*60);

require_once('/var/www/simplesaml/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();
$as->logout('https://sp1.local/sample/complete.php');
?> 
