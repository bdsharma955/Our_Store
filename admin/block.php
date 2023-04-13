<?php 
session_start();
require_once('../config.php');

$user_id = $_REQUEST['id'];
// $id = $_REQUEST['id'];

$stm = $connection->prepare("UPDATE users SET status=? WHERE id=?");
$stm->execute(array('Blocked',$user_id));

$url = 'all-users.php?success=Data Blocked Successfully!';

header("location:$url");

?>