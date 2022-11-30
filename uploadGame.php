<?php

use Dcblogdev\PdoWrapper\Database;

require "function.php";

global $options;
$db = new Database($options);

$username = $_POST['user_id'];
$time = $_POST['time'];

$db->insert('Games', ['score' => 1, 'time' => $_POST['time'], 'user_id' => $_POST['user_id']]);
// $db->lastInsertId()();

