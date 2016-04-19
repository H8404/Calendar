<?php
$db = new PDO('mysql:host=mysql.labranet.jamk.fi;dbname=H8404_3;charset=utf8',
              'H8404', 'dWcKwAt9Ftw25xxB25jP7nb8ZHUdf5rL');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>