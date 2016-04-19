<?php
$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8',
              'user', 'password');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
