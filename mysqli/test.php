<?php
require_once 'mysqli.class.php';
$db = dbmysqlidb::getInstance('mysqli_test');
$data = array(
		'name' => uniqid(),
		'addtime' => time()
);
$id = $db->query($link, $query);
//111111111111111111111
var_dump($id);