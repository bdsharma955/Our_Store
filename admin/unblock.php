<?php 
session_start();
require_once('../config.php');

$user_id = $_REQUEST['id'];

$stm = $connection->prepare("UPDATE users SET status=? WHERE id=?");
$stm->execute(array('Active',$user_id));

$url = 'all-users.php?success=Data Unblock Successfully!';

header("location:$url");

?>